package main

import (
	"path/filepath"
	"log"
	"fmt"
	"os/user"
	"os"
	"net/url"
	"encoding/json"
	"golang.org/x/oauth2"
	"golang.org/x/net/context"
	"net/http"
	"io/ioutil"
	"golang.org/x/oauth2/google"
	"google.golang.org/api/drive/v3"
	"strings"
)

var config *oauth2.Config

const BOOK_TITLE = "t"
const BOOK_AUTHOR = "a"
const BOOK_INSTITUTION = "i"
const BOOK_DATE = "d"
const BOOK_SUBJECT = "s"

func init() {
	b, err := ioutil.ReadFile("client_secret.json")

	if err != nil {
		log.Fatalf("Unable to read client secret file: %v", err)
	}

	config, err = google.ConfigFromJSON(b, drive.DriveMetadataReadonlyScope)

	if err != nil {
		log.Fatalf("Unable to parse client secret file to config: %v", err)
	}
}

type GoogleDriveParams struct {
	Search      string
	Title       string
	Institution string
	Date        string
	Subject     string
	Author      string
	PageToken   string
}

func (p *GoogleDriveParams) ToQuery() (query string) {
	p.normalizeValues()

	query = "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents"

	if len(p.Search) > 0 {
		query += fmt.Sprintf(" and (fullText contains '%v' or name contains '%v')", p.Search, p.Search)
	}

	props := make(map[string]string)

	if len(p.Title) > 0 {
		props[BOOK_TITLE] = p.Title
	}
	if len(p.Institution) > 0 {
		props[BOOK_INSTITUTION] = p.Institution
	}
	if len(p.Date) > 0 {
		props[BOOK_DATE] = p.Date
	}
	if len(p.Subject) > 0 {
		props[BOOK_SUBJECT] = p.Subject
	}
	if len(p.Author) > 0 {
		props[BOOK_AUTHOR] = p.Author
	}

	if len(props) > 0 {
		query += p.buildProps(props)
	}

	return
}

func (p *GoogleDriveParams) buildProps(props map[string]string) (result string) {
	for key, value := range props {
		result += fmt.Sprintf(" and properties has {key='%v' and value='%v'}", key, value)
	}

	return
}

func (p *GoogleDriveParams) normalizeValues() {
	p.escapeValues()
	p.cropValues()
}

func (p *GoogleDriveParams) escapeValues() {
	p.Search = strings.Replace(p.Search, "'", "\\'", -1)
	p.Title = strings.Replace(p.Title, "'", "\\'", -1)
	p.Institution = strings.Replace(p.Institution, "'", "\\'", -1)
	p.Date = strings.Replace(p.Date, "'", "\\'", -1)
	p.Author = strings.Replace(p.Author, "'", "\\'", -1)
	p.Subject = strings.Replace(p.Subject, "'", "\\'", -1)
}

func (p *GoogleDriveParams) cropValues() {
	p.Title = strCut(p.Title, 41)
	p.Institution = strCut(p.Institution, 41)
	p.Date = strCut(p.Date, 41)
	p.Author = strCut(p.Author, 41)
	p.Subject = strCut(p.Subject, 41)
}

type GoogleDrive struct {
}

func (d *GoogleDrive) FindFiles(params GoogleDriveParams) (files []*drive.File, pageToken string, err error) {
	srv := getSrv()

	r, err := srv.Files.List().
		PageSize(100).
		Q(params.ToQuery()).
		Fields("nextPageToken, files(id, name)").
		PageToken(params.PageToken).
		Do()

	if err != nil {
		return
	}

	files = r.Files
	pageToken = r.NextPageToken
	return
}

func (d *GoogleDrive) IsLoggedIn() bool {
	cacheFile, err := tokenCacheFile()

	if err != nil {
		log.Fatalf("Unable to get path to cached credential file. %v", err)
	}

	if _, err = tokenFromFile(cacheFile); err != nil {
		return false
	}

	return true
}

func (d *GoogleDrive) GetLoginLink() string {
	return getAuthLink()
}

func (d *GoogleDrive) LogIn(code string) (err error) {
	cacheFile, err := tokenCacheFile()

	if err != nil {
		return
	}

	tok, err := getTokenFromWeb(config, code)

	if err != nil {
		return
	}

	saveToken(cacheFile, tok)
	return
}

func getSrv() drive.Service {
	ctx := context.Background()
	client := getClient(ctx, config)
	srv, err := drive.New(client)

	if err != nil {
		log.Fatalf("Unable to retrieve drive Client %v", err)
	}

	return *srv
}

// getClient uses a Context and Config to retrieve a Token
// then generate a Client. It returns the generated Client.
func getClient(ctx context.Context, config *oauth2.Config) *http.Client {
	cacheFile, err := tokenCacheFile()
	if err != nil {
		log.Fatalf("Unable to get path to cached credential file. %v", err)
	}

	tok, err := tokenFromFile(cacheFile)

	return config.Client(ctx, tok)
}

func getAuthLink() string {
	return config.AuthCodeURL("state-token", oauth2.AccessTypeOffline, oauth2.ApprovalForce)
}

// getTokenFromWeb uses Config to request a Token.
// It returns the retrieved Token.
func getTokenFromWeb(config *oauth2.Config, code string) (*oauth2.Token, error) {
	tok, err := config.Exchange(oauth2.NoContext, code)
	if err != nil {
		return nil, err
	}

	return tok, nil
}

// tokenCacheFile generates credential file path/filename.
// It returns the generated credential path/filename.
func tokenCacheFile() (string, error) {
	usr, err := user.Current()
	if err != nil {
		return "", err
	}
	tokenCacheDir := filepath.Join(usr.HomeDir, ".credentials")
	os.MkdirAll(tokenCacheDir, 0700)
	return filepath.Join(tokenCacheDir,
		url.QueryEscape("drive-go.json")), err
}

// tokenFromFile retrieves a Token from a given file path.
// It returns the retrieved Token and any read error encountered.
// Fix: it will just read token.json
func tokenFromFile(file string) (*oauth2.Token, error) {
	f, err := os.Open("/go/src/project/token.json")
	if err != nil {
		return nil, err
	}
	t := &oauth2.Token{}
	err = json.NewDecoder(f).Decode(t)
	d, _ := json.Marshal(t)
	fmt.Printf("%s\n", string(d))
	defer f.Close()
	return t, err
}

// saveToken uses a file path to create a file and store the
// token in it.
func saveToken(file string, token *oauth2.Token) {
	fmt.Printf("Saving credential file to: %s\n", file)
	f, err := os.OpenFile(file, os.O_RDWR|os.O_CREATE|os.O_TRUNC, 0600)
	if err != nil {
		log.Fatalf("Unable to cache oauth token: %v", err)
	}
	defer f.Close()
	json.NewEncoder(f).Encode(token)
}

func strCut(s string, length int) string {
	runes := []rune(s)
	l := length

	if l > len(runes) {
		l = len(runes)
	}

	return string(runes[0:l])
}

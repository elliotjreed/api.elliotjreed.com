<?php
declare(strict_types=1);

namespace ElliotJReed\Retrievers;

use ElliotJReed\Formatters\Url;
use DateTime;
use GuzzleHttp\ClientInterface;
use Spatie\SchemaOrg\AboutPage;
use Spatie\SchemaOrg\Blog;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\BreadcrumbList;
use Spatie\SchemaOrg\ContactPage;
use Spatie\SchemaOrg\EducationalOrganization;
use Spatie\SchemaOrg\Language;
use Spatie\SchemaOrg\ListItem;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\ProfilePage;
use Spatie\SchemaOrg\WebPage;
use Spatie\SchemaOrg\WebSite;
use stdClass;

class NginxIndex
{
    private $guzzle;
    private $urlFormatter;
    private $categories = [];
    private $posts = [];

    public function __construct(ClientInterface $guzzle, Url $urlFormatter)
    {
        /** @var ClientInterface guzzle */
        $this->guzzle = $guzzle;
        $this->urlFormatter = $urlFormatter;
    }

    public function getWebsite(): WebSite
    {
        $author = $this->getAuthor();
        $language = $this->getLanguage();
        $about = (new AboutPage())
            ->author($author)
            ->publisher($author)
            ->url('')
            ->name('')
            ->description('')
            ->inLanguage($language)
            ->mainEntityOfPage('');
        $contact = (new ContactPage())
            ->author($author)
            ->publisher($author)
            ->url('')
            ->name('')
            ->description('')
            ->inLanguage($language)
            ->mainEntityOfPage('');
        $profile = (new ProfilePage())
            ->author($author)
            ->publisher($author)
            ->url('')
            ->name('')
            ->description('')
            ->inLanguage($language)
            ->mainEntityOfPage('');
        $webpage = (new WebPage())
            ->breadcrumb((new BreadcrumbList())
                ->itemListElement(array_merge([$about, $contact, $profile], $this->categories)));

        return (new WebSite())
            ->mainEntity($webpage);
    }

    public function getCategories()
    {
        return (new BreadcrumbList())
            ->itemListElement($this->categories);
    }

    public function retrieve(string $uri = ''): NginxIndex
    {
        $body = $this->guzzle->request('GET', $uri)->getBody();
        foreach (json_decode($body->read($body->getSize()), true) as $item) {
            if ($item['type'] === 'directory') {
                $this->parseDirectory($uri, $item);
            }
        }

        return $this;
    }

    private function parseDirectory(string $uri, array $item): void
    {
        $categoryLink = $uri . '/' . rawurlencode($item['name']);
        $categoryContents = $this->guzzle->request('GET', $categoryLink)->getBody();
        $posts = [];
        foreach (json_decode($categoryContents->read($categoryContents->getSize()), true) as $categoryItem) {
            if ($categoryItem['type'] === 'file') {
                $posts[] = $this->parsePosts($categoryItem, $categoryLink);
            }
        }

        $this->categories[$uri . '/' . $this->urlFormatter->format($item['name'])] = [
            'name' => $item['name'],
            'link' => $categoryLink,
            'posts' => $posts
        ];

        $this->categories[] = (new ListItem())
            ->name($item['name'])
            ->url($uri . '/' . $this->urlFormatter->format($item['name']))
            ->item((new Blog())
                ->blogPosts($posts));
        $this->retrieve($categoryLink);
    }

    private function parsePosts(stdClass $item, string $uri): BlogPosting
    {
        $content = $this->guzzle->request('GET', $uri . '/' . rawurlencode($item->name))->getBody();
        $fileNameWithoutExtension = pathinfo($item->name, PATHINFO_FILENAME);
        $slug = strtolower($uri) . '/' . substr($this->urlFormatter->format($fileNameWithoutExtension), 20);
        $link = $uri . '/' . rawurlencode($item->name);

        $this->posts[$link] = [
            'title' => substr($this->urlFormatter->format($fileNameWithoutExtension), 20),
            'body' => $content->read($content->getSize()),
            'created' => new DateTime(substr($item->name, 0, 19)),
            'modified' => new DateTime($item->mtime),
            'slug' => $slug,
            '' => ,
            '' => ,

        ];

        return $posts;
    }

    private function getLanguage(): Language
    {
        return (new Language())->name('English')->alternateName('en-GB');
    }

    private function getAuthor(): Person
    {
        return (new Person())
            ->name('Elliot J. Reed')
            ->familyName('Reed')
            ->birthDate(new DateTime('1990-02-25'))
            ->alumniOf(
                (new EducationalOrganization())
                    ->name('University of Nottingham')
                    ->sameAs('https://www.nottingham.ac.uk/')
            )
            ->email('website@elliotjreed.com');
    }


}

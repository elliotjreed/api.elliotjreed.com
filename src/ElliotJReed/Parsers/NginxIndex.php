<?php
declare(strict_types=1);

namespace ElliotJReed\Parsers;

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

class NginxIndex
{
    private $guzzle;
    private $urlFormatter;

    public function __construct(ClientInterface $guzzle, Url $urlFormatter)
    {
        /** @var ClientInterface guzzle */
        $this->guzzle = $guzzle;
        $this->urlFormatter = $urlFormatter;
    }

    public function parse()
    {
        $itemList = [];
        $language = (new Language())->name('English')->alternateName('en-GB');
        $author = (new Person())
            ->name('Elliot J. Reed')
            ->familyName('Reed')
            ->birthDate(new DateTime('1990-02-25'))
            ->alumniOf(
                (new EducationalOrganization())
                    ->name('University of Nottingham')
                    ->sameAs('https://www.nottingham.ac.uk/')
            )
            ->email('website@elliotjreed.com');

        $body = $this->guzzle->request('GET', '/')->getBody();

        $blogPosts = [];
        foreach (json_decode($body->read($body->getSize())) as $item) {
            if ($item->type === 'directory') {
                $categoryLink = rawurlencode($item->name);
                $categorySlug = $this->urlFormatter->format($item->name);

                $body = $this->guzzle->request('GET', '/' . $categoryLink)->getBody();
                foreach (json_decode($body->read($body->getSize())) as $categoryItem) {
                    if ($categoryItem->type === 'file') {
                        $articleBody = $this->guzzle->request('GET', '/' . $categoryLink . '/' . rawurlencode($categoryItem->name))->getBody();

                        $blogPosts[] = (new BlogPosting())
                            ->headline($categoryItem->name)
                            ->author($author)
                            ->publisher($author)
                            ->articleBody($articleBody->read($articleBody->getSize()))
                            ->copyrightHolder($author)
                            ->dateCreated(new DateTime(substr($categoryItem->name, 0, 19)))
                            ->datePublished(new DateTime(substr($categoryItem->name, 0, 19)))
                            ->dateModified(new DateTime($categoryItem->mtime))
                            ->inLanguage($language)
                            ->description($categoryItem->name)
                            ->url($categorySlug . '/' . $this->urlFormatter->format($categoryItem->name))
                            ->mainEntityOfPage($categorySlug . '/' . $this->urlFormatter->format($categoryItem->name) . '#main');
                    }
                }
                $itemList[] = (new ListItem())->name($item->name)->url($categorySlug)->item((new Blog())->blogPosts($blogPosts));
            }

        }
        $about = (new AboutPage())->author($author)->publisher($author)->url('')->name('')->description('')->inLanguage($language)->mainEntityOfPage('');
        $contact = (new ContactPage())->author($author)->publisher($author)->url('')->name('')->description('')->inLanguage($language)->mainEntityOfPage('');
        $profile = (new ProfilePage())->author($author)->publisher($author)->url('')->name('')->description('')->inLanguage($language)->mainEntityOfPage('');
        $webpage = (new WebPage())->breadcrumb((new BreadcrumbList())->itemListElement($itemList));

        return (new WebSite())->mainEntity([$about, $contact, $profile, $webpage]);
    }
}

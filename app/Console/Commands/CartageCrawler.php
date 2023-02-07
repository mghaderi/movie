<?php

namespace App\Console\Commands;

use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CartageCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:cartage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for crawling cartage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $moviesData = [];
        $movies = $this->sendRequest(
            'get',
            'https://moviecottage.icu/wp-json/wp/v2/search?page=1&per_page=100',
            [], [] , 0
        )->json();
        foreach($movies as $movie) {
            if ($movie['id'] = 29351) {
                $moviesData[] = [
                    'movieId' => $movie['id'],
                    'movieTitle' => $movie['title'],
                    'movieUrl' => $movie['url'],
                    'movieDetail' => $this->movieDetailData($movie['_links']['self'][0]['href']),
                    'movieCrawl' => $this->fetchCrawlData($movie['url']),
                    'movieSource' => $this->fetchMovieLinks($movie['id']),
                ];
                dd($moviesData);
            }
        }
        dd($moviesData);
    }

    public function fetchMovieLinks($movieId) {
        $cookies = $this->fetchCookie();
        $response = $this->sendRequest(
            'get',
            'https://moviecottage.icu/playonline/'. $movieId .'/',
            [], $cookies, 0
        );
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        $sources = $dom->getElementsByTagName('source');
        $result = [];
        $hasSource = false;
        foreach ($sources as $source) {
            $hasSource = true;
            $src = '';
            $quallity = '';
            foreach ($source->attributes as $attribute) {
                if ($attribute->name == 'src') {
                    $src = $attribute->value;
                } elseif ($attribute->name == 'size') {
                    $quallity = $attribute->value;
                }
            }
            $result[] = [
                'source' => $src,
                'quallity' => $quallity,
            ];
        }
        if ($hasSource === false) {
            $season = 1;
            $episode = 1;
            $url = 'https://moviecottage.icu/playonline/'
                . $movieId .'/' . '?se=' . $season . '&ep=' . $episode;
            $serialSources = $this->fetchSerialLinks($url, $cookies);
            while (!empty($serialSources)) {
                while (!empty($serialSources)) {
                    $result[] = [
                        'season' => $season,
                        'episode' => $episode,
                        'links' => $serialSources
                    ];
                    $episode = $episode + 1;
                    $url = 'https://moviecottage.icu/playonline/'
                        . $movieId .'/' . '?se=' . $season . '&ep=' . $episode;
                    $serialSources = $this->fetchSerialLinks($url, $cookies);
                }
                $season = $season + 1;
                $episode = 1;
                $url = 'https://moviecottage.icu/playonline/'
                    . $movieId .'/' . '?se=' . $season . '&ep=' . $episode;
                $serialSources = $this->fetchSerialLinks($url, $cookies);
            }
        }
        return $result;
    }

    public function fetchSerialLinks($url, $cookies) {
        $response = $this->sendRequest('get', $url, [], $cookies, 0);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        $sources = $dom->getElementsByTagName('source');
        $result = [];
        foreach ($sources as $source) {
            $src = '';
            $quallity = '';
            foreach ($source->attributes as $attribute) {
                if ($attribute->name == 'src') {
                    $src = $attribute->value;
                } elseif ($attribute->name == 'size') {
                    $quallity = $attribute->value;
                }
            }
            $result[] = [
                'source' => $src,
                'quallity' => $quallity,
            ];
        }
        return $result;
    }

    public function fetchCookie()
    {
        $response = $this->sendRequest('get', 'https://moviecottage.icu/account-login/', [], [], 0);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->body());
        $xp = new DOMXPath($dom);
        $nodes = $xp->query('//input[@name="login_security"]');
        $node = $nodes->item(0) ?? null;
        $security = $node->getAttribute('value');
        $response = $this->sendRequest(
            'post',
            'https://moviecottage.icu/wp-admin/admin-ajax.php',
            [
                'action' => 'ajaxLoginWPF',
                'username' => 'mohamadmam',
                'password' => '1qaz@WSX',
                'security' => $security,
            ], [] , 0
        );
        $result = [];
        foreach ($response->cookies() as $cookie) {
            if (strpos($cookie->getName(), 'wordpress_sec_') === false) {
                $result[$cookie->getName()] = $cookie->getValue();
            }
        }
        return $result;
    }

    public function movieDetailData($route) {
        $data = $this->sendRequest('get', $route, [], [], 0)->json();
        $actorsData = [];
        $countryData = [];
        $directorData = [];
        $releaseData = [];
        $categoryData = [];
        foreach ($data['_links']['wp:term'] as $wpTerm) {
            if (strpos($wpTerm['taxonomy'], 'act') !== false) {
                $actorsData = $this->fetchTermsData($wpTerm['href']);
            } elseif (strpos($wpTerm['taxonomy'], 'country') !== false) {
                $countryData = $this->fetchTermsData($wpTerm['href']);
            } elseif (strpos($wpTerm['taxonomy'], 'dir') !== false) {
                $directorData = $this->fetchTermsData($wpTerm['href']);
            } elseif (strpos($wpTerm['taxonomy'], 'genre') !== false) {
                $genreData = $this->fetchTermsData($wpTerm['href']);
            } elseif (strpos($wpTerm['taxonomy'], 'language') !== false) {
                $languageData = $this->fetchTermsData($wpTerm['href']);
            } elseif (strpos($wpTerm['taxonomy'], 'release') !== false) {
                $releaseData = $this->fetchTermsData($wpTerm['href']);
            } elseif (strpos($wpTerm['taxonomy'], 'category') !== false) {
                $categoryData = $this->fetchTermsData($wpTerm['href'], 'slug');
            }
        }
        return [
            'ttName' => $data['slug'],
            'status' => $data['status'],
            'media_data' => $this->fetchMediaData($data['_links']['wp:featuredmedia'][0]['href']),
            'actor_data' => $actorsData,
            'country_data' => $countryData,
            'director_data' => $directorData,
            'genre_data' => $genreData,
            'language_data' => $languageData,
            'release_data' => $releaseData,
            'category_data' => $categoryData,
        ];
    }

    public function fetchTermsData($route, $element = 'name')
    {
        $terms = $this->sendRequest('get', $route, [], [], 0)->json();
        $response = [];
        foreach($terms as $term) {
            $response[] = $term[$element];
        }
        return $response;
    }

    public function fetchMediaData($route) {
        $media = $this->sendRequest('get', $route, [], [], 0)->json();
        return [
            'medium_url' => $media['media_details']['sizes']['medium']['source_url'],
            'medium_type' => $media['media_details']['sizes']['medium']['mime_type'],
            'index_film_url' => $media['media_details']['sizes']['indexFilm']['source_url'],
            'index_film_type' => $media['media_details']['sizes']['indexFilm']['mime_type'],
            'special_post_url' => $media['media_details']['sizes']['specialPost']['source_url'],
            'special_post_type' => $media['media_details']['sizes']['specialPost']['mime_type'],
            'single_film_url' => $media['media_details']['sizes']['singleFilm']['source_url'],
            'single_film_type' => $media['media_details']['sizes']['singleFilm']['mime_type'],
            'full_url' => $media['media_details']['sizes']['full']['source_url'],
            'full_type' => $media['media_details']['sizes']['full']['mime_type'],
        ];
    }

    public function fetchCrawlData($route) {
        $html = $this->sendRequest('get', $route, [], [], 0)->body();
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $response = $this->elementToObject($dom->documentElement)['result'];
        return [
            'rate' => $response['rate'] ?? '',
            'score' => $response['score'] ?? '',
            'other' => $response['movie_data'] ?? ''
        ];
    }

    public function elementToObject($element, $result = []) {
        if (isset($element->tagName)) {
            $obj = ['tag' => $element->tagName];
        }

        if (isset($element->attributes)) {
            foreach ($element->attributes as $attribute) {
                if (strpos($attribute->value, '-rate-value') !== false) {
                    foreach ($element->childNodes as $subElement) {
                        $result['rate'] = $subElement->data;
                    }
                } elseif (strpos($attribute->value, '-score-value') !== false) {
                    foreach ($element->childNodes as $subElement) {
                        $result['score'] = $subElement->data;
                    }
                } elseif (strpos($attribute->value, 'postMain') !== false) {
                    $ul = $element->getElementsByTagName('ul');
                    foreach ($ul->item(0)->getElementsByTagName('li') as $subElement) {
                        // while ($subElement->hasChildNodes()) {
                        //     if ($subElement->firstChild->nodeType != XML_TEXT_NODE) {
                        //         $subElement->removeChild($subElement->firstChild);
                        //     } else {
                        //         break;
                        //     }
                        // }
                        $result['movie_data'][] = trim($subElement->nodeValue);
                    }
                }
                $obj[$attribute->name] = $attribute->value;
            }
        }
        if (isset($element->childNodes)) {
            foreach ($element->childNodes as $subElement) {
                if ($subElement->nodeType == XML_TEXT_NODE) {
                    $obj['html'] = $subElement->wholeText;
                } elseif ($subElement->nodeType == XML_CDATA_SECTION_NODE) {
                    $obj['html'] = $subElement->data;
                } else {
                    $response = $this->elementToObject($subElement, $result);
                    $result = $response['result'];
                    $obj['children'][] = $response['obj'];
                }
            }
        }
        return [
            'obj' => (isset($obj)) ? $obj : null,
            'result' => $result
        ];
    }

    public function sendRequest($method , $url, $data = [], $cookies = [], $counter = 0) {
        dump('sleeping...');
        sleep(1);
        $counter = $counter + 1 ;
        dump('try: ' . $counter);
        dump('url: ' . $url);
        dump('method: ' . $method);
        dump('data: ' . implode(',', $data));
        dump('cookies: ' . implode(',', $cookies));
        try {
            if (! empty($cookies) && ($counter > 3)) {
                $cookies = $this->fetchCookie();
            }
            if ($method == 'post') {
                return Http::asForm()->post($url, $data);
            } elseif ($method == 'get') {
                if (! empty($cookies)) {
                    return Http::withCookies($cookies, 'moviecottage.icu')
                        ->get($url);
                } else {
                    return Http::get($url);
                }
            }
        } catch (\Exception $exception) {
            return $this->sendRequest($method , $url, $data, $cookies, $counter);
        }
        return [];
    }

}

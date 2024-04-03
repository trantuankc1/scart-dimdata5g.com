<?php
#App\Plugins\Other\SiteMapBasic\Controllers\FrontController.php
namespace App\Plugins\Other\SiteMapBasic\Controllers;

use App\Plugins\Other\SiteMapBasic\AppConfig;
use SCart\Core\Front\Controllers\RootFrontController;
use SCart\Core\Front\Models\ShopPage;
use SCart\Core\Front\Models\ShopNews;
use SCart\Core\Front\Models\ShopProduct;
use SCart\Core\Front\Models\ShopCategory;
use App\Plugins\Cms\Content\Models\CmsContent;
use App\Plugins\Cms\Content\Models\CmsCategory;
use Carbon\Carbon;
use Cache;

class FrontController extends RootFrontController
{
    public $plugin;
    public $pages;
    public $blogs;
    public $products;
    public $categories;
    public $time;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
        $this->pages = (new ShopPage)->where('status', 1)->get();
        $this->blogs = (new ShopNews)->where('status', 1)->get();
        $this->products = (new ShopProduct)->where('status', 1)->get();
        $this->categories = (new ShopCategory)->where('status', 1)->get();
        $this->time = Carbon::now()->format('Y-m-d\TH:i:s.uP');
    }

    public function index() {

      if (!Cache::has('cache_SiteMapBasic_basic')) {
        $xml     = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset
              xmlns="http://www.SiteMapBasics.org/schemas/SiteMapBasic/0.9"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://www.SiteMapBasics.org/schemas/SiteMapBasic/0.9
                    http://www.SiteMapBasics.org/schemas/SiteMapBasic/0.9/SiteMapBasic.xsd">';
        $xml .= '
        <url>
        <loc>' . sc_route("home") . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>1.00</priority>
        </url>
        ';

        if (!config('app.seoLang') || !count(sc_language_all())) {
            $xml .=$this->processUrlWithLang();
        } else {
            foreach (sc_language_all() as $codeLang => $lang) {
                $xml .=$this->processUrlWithLang($codeLang);
            }
        }

        $xml .= '</urlset>';
        sc_set_cache('cache_SiteMapBasic_basic', $xml, 600);
      }
      
      header("Content-type: text/xml");
      echo Cache::get('cache_SiteMapBasic_basic');
      exit;
    }

    public function processUrlWithLang($lang = null) {
      $xml = '<url>
        <loc>' . sc_route('cart', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
      </url>';
      $xml .= '<url>
        <loc>' . sc_route('checkout', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
      </url>';
      $xml .= '<url>
        <loc>' . sc_route('login', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
      </url>';
      $xml .= '<url>
        <loc>' . sc_route('register', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
      </url>';
      $xml .= '<url>
        <loc>' . sc_route('forgot', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
      </url>';
      $xml .= '<url>
        <loc>' . sc_route('contact', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
      </url>';
      $xml .= '<url>
        <loc>' . sc_route('search', ['lang' => $lang]) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        </url>';
      foreach ($this->products as $key => $product) {
          $xml .= '<url>
          <loc>' . $product->getUrl($lang) . '</loc>
          <lastmod>' . $this->time . '</lastmod>
          <priority>0.8</priority>
          <changefreq>weekly</changefreq>
        </url>';
      }
      foreach ($this->categories as $key => $category) {
          $xml .= '<url>
          <loc>' . $category->getUrl($lang) . '</loc>
          <lastmod>' . $this->time . '</lastmod>
          <priority>0.8</priority>
          <changefreq>weekly</changefreq>
        </url>';
      }
      foreach ($this->pages as $key => $page) {
          $xml .= '<url>
          <loc>' . $page->getUrl($lang) . '</loc>
          <lastmod>' . $this->time . '</lastmod>
          <priority>0.8</priority>
          <changefreq>weekly</changefreq>
        </url>';
      }
      if (sc_config('Content')) {
        $contents = (new \App\Plugins\Cms\Content\Models\CmsContent)->where('status', 1)->get();
        $cmsCategory = (new \App\Plugins\Cms\Content\Models\CmsCategory)->where('status', 1)->get();
        foreach ($contents as $key => $item) {
          $xml .= '<url>
          <loc>' . $item->getUrl($lang) . '</loc>
          <lastmod>' . $this->time . '</lastmod>
          <priority>0.64</priority>
          <changefreq>weekly</changefreq>
          </url>';
        }
        foreach ($cmsCategory as $key => $cmsCategory) {
          $xml .= '<url>
          <loc>' . $cmsCategory->getUrl($lang) . '</loc>
          <lastmod>' . $this->time . '</lastmod>
          <priority>0.64</priority>
          <changefreq>weekly</changefreq>
          </url>';
        }
      }
      foreach ($this->blogs as $key => $blog) {
        $xml .= '<url>
        <loc>' . $blog->getUrl($lang) . '</loc>
        <lastmod>' . $this->time . '</lastmod>
        <priority>0.64</priority>
        <changefreq>weekly</changefreq>
        </url>';
      }
      return $xml;
    }


}

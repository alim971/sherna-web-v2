<?php

use Illuminate\Database\Seeder;

class NavPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Nav\Page::updateOrInsert([
            'id' => 1,
            'url'   => 'o-sherne',
            'name'   => 'O Sherne',
            'language_id' => 1,
            'order' => 1,
            'public' => false,
            'dropdown' => true
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 2,
            'url'   => 'blog',
            'name'   => 'Blog',
            'language_id' => 1,
            'order' => 2,
            'public' => false,
            'dropdown' => true
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 3,
            'url'   => 'rezervace',
            'name'   => 'Rezervace',
            'language_id' => 1,
            'order' => 3,
            'public' => false,
            'dropdown' => false
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 3,
            'url'   => 'reservation',
            'name'   => 'Reservation',
            'language_id' => 2,
            'order' => 3,
            'public' => false,
            'dropdown' => false
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 4,
            'url'   => 'fotogalerie',
            'name'   => 'Forogalerie',
            'language_id' => 1,
            'order' => 4,
            'public' => false,
            'dropdown' => false
        ]);
        \App\Nav\SubPage::updateOrInsert([
            'id' => 1,
            'url'   => 'about/clenove',
            'name'   => 'Clenove',
            'nav_page_id' => 1,
            'language_id' => 1,
            'order' => 1,
            'public' => false,
        ]);
        \App\Nav\SubPage::updateOrInsert([
            'id' => 2,
            'url'   => 'about/vyrocni-spravy',
            'name'   => 'Vyrocni spravy',
            'nav_page_id' => 1,
            'language_id' => 1,
            'order' => 2,
            'public' => false,
        ]);
        \App\Nav\SubPage::updateOrInsert([
            'id' => 3,
            'url'   => 'blog/hry',
            'name'   => 'Hry',
            'nav_page_id' => 2,
            'language_id' => 1,
            'order' => 1,
            'public' => false,
        ]);
        \App\Nav\SubPageText::updateOrInsert([
            'id' => 1,
            'title'   => 'Clenove',
            'nav_subpage_id' => 1,
            'language_id' => 1,
            'content' => 'Example exapmle'
        ]);
        \App\Nav\SubPageText::updateOrInsert([
            'id' => 2,
            'title'   => 'Vyrocne spravy',
            'nav_subpage_id' => 2,
            'language_id' => 1,
            'content' => '2 Example example 2'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 1,
            'title'   => 'Rezervacia',
            'nav_page_id' => 2,
            'language_id' => 1,
            'content' => '2 Example example 2'
        ]);
        \App\Nav\PageText::updateOrInsert([
            'id' => 2,
            'title'   => 'Reservation',
            'nav_page_id' => 2,
            'language_id' => 2,
            'content' => 'En EN En Example example En'
        ]);
    }
}

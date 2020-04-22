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
            'url'   => 'about',
            'name'   => 'O Sherne',
            'language_id' => 1,
            'order' => 1,
            'public' => false,
            'dropdown' => true
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 1,
            'url'   => 'about',
            'name'   => 'About Sherna',
            'language_id' => 2,
            'order' => 1,
            'public' => false,
            'dropdown' => true
        ]);

        \App\Nav\Page::updateOrInsert([
            'id' => 2,
            'url'   => 'home',
            'name'   => 'Domov',
            'language_id' => 1,
            'order' => 2,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'home'
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 2,
            'url'   => 'home',
            'name'   => 'Home',
            'language_id' => 2,
            'order' => 2,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'home'
        ]);

        \App\Nav\Page::updateOrInsert([
            'id' => 3,
            'url'   => 'reservation',
            'name'   => 'Rezervace',
            'language_id' => 1,
            'order' => 3,
            'public' => false,
            'dropdown' => false,
            'special_code' => 'reservation'
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 3,
            'url'   => 'reservation',
            'name'   => 'Reservation',
            'language_id' => 2,
            'order' => 3,
            'public' => false,
            'dropdown' => false,
            'special_code' => 'reservation'
        ]);

        \App\Nav\Page::updateOrInsert([
            'id' => 4,
            'url'   => 'inventory',
            'name'   => 'Vybaveni',
            'language_id' => 1,
            'order' => 4,
            'public' => false,
            'dropdown' => false,
            'special_code' => 'inventory'
        ]);
        \App\Nav\Page::updateOrInsert([
            'id' => 4,
            'url'   => 'inventory',
            'name'   => 'Inventory',
            'language_id' => 2,
            'order' => 4,
            'public' => false,
            'dropdown' => false,
            'special_code' => 'inventory'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 1,
            'title'   => 'Rezervace',
            'nav_page_id' => 3,
            'language_id' => 1,
            'content' => 'Reservace exapmle'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 2,
            'title'   => 'Reservation',
            'nav_page_id' => 3,
            'language_id' => 2,
            'content' => 'Reservation exapmle'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 3,
            'title'   => 'Domov',
            'nav_page_id' => 2,
            'language_id' => 1,
            'content' => 'Vitajte exapmle'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 4,
            'title'   => 'Home',
            'nav_page_id' => 2,
            'language_id' => 2,
            'content' => 'Welcome exapmle'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 5,
            'title'   => 'Vybavenie',
            'nav_page_id' => 4,
            'language_id' => 1,
            'content' => 'Vitajte exapmle'
        ]);

        \App\Nav\PageText::updateOrInsert([
            'id' => 6,
            'title'   => 'Inventory',
            'nav_page_id' => 4,
            'language_id' => 2,
            'content' => 'Welcome exapmle'
        ]);

        \App\Nav\SubPage::updateOrInsert([
            'id' => 1,
            'url'   => 'clenove',
            'name'   => 'Clenove',
            'nav_page_id' => 1,
            'language_id' => 1,
            'order' => 1,
            'public' => false,
        ]);
        \App\Nav\SubPage::updateOrInsert([
            'id' => 1,
            'url'   => 'clenove',
            'name'   => 'Members',
            'nav_page_id' => 1,
            'language_id' => 2,
            'order' => 2,
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
            'nav_subpage_id' => 1,
            'language_id' => 2,
            'content' => '2 Example example 2'
        ]);

    }
}

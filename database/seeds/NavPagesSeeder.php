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
            'id' => 2,
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
            'nav_subpage_id' => 2,
            'language_id' => 1,
            'content' => '2 Example example 2'
        ]);

    }
}

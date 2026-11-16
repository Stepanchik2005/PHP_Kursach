<?php
namespace app\tests\Functional;

use app\tests\Support\FunctionalTester;

class PostCest
{
    public function _before(FunctionalTester $I)
    {
        // Передаем точный URL как строку через параметр r
        $I->amOnPage('/index.php?r=post%2Findex');
    }

    public function checkPostsPageWorks(FunctionalTester $I)
    {
        $I->see('Публікації блогу', 'h1');
        $I->seeElement('.post-card');
        $I->seeElement('.post-title');
    }

    public function checkPaginationExists(FunctionalTester $I)
    {
        $I->seeElement('.pagination');
    }
}
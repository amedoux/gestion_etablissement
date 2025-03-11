<?php
class AccueilCest
{
    public function testPageAccueil(AcceptanceTester $I)
    {
        $I->amOnPage('/');  
        $I->see('Bienvenue sur la Gestion des Classes');
    }
}

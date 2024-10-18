<?php

namespace TTN\Tea\Tests\Functional\Controller;

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * @covers \TTN\Tea\Controller\TopTeaController
 */
final class TopTeaControllerTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['ttn/tea'];

    protected array $coreExtensionsToLoad = ['typo3/cms-fluid-styled-content'];

    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/tea/Tests/Functional/Controller/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/SiteStructure.csv');
        $this->setUpFrontendRootPage(1, [
            'constants' => [
                'EXT:fluid_styled_content/Configuration/TypoScript/constants.typoscript',
                'EXT:tea/Configuration/TypoScript/constants.typoscript',
                'EXT:tea/Tests/Functional/Controller/Fixtures/TypoScript/Constants/PluginConfiguration.typoscript',
            ],
            'setup' => [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.typoscript',
                'EXT:tea/Configuration/TypoScript/setup.typoscript',
                'EXT:tea/Tests/Functional/Controller/Fixtures/TypoScript/Setup/Rendering.typoscript',
            ],
        ]);
    }

    /**
     * @test
     */
    public function indexActionWithNoTopTeasRendersNotFoundMessage(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/ContentElementTopTeaIndex.csv');

        $request = new InternalRequest();
        $request = $request->withPageId(1);

        $html = (string)$this->executeFrontendSubRequest($request)->getBody();

        self::assertStringContainsString('No Top Teas found.', $html);
    }

    /**
     * @test
     */
    public function indexActionWithTopTeasRendersTopTeas(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/ContentElementTopTeaIndex.csv');
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Database/TopTeas.csv');

        $request = new InternalRequest();
        $request = $request->withPageId(1);

        $html = (string)$this->executeFrontendSubRequest($request)->getBody();

        self::assertStringContainsString('Earl Grey', $html);
        self::assertStringContainsString('Zorro', $html);
        self::assertStringNotContainsString('Assam', $html);
    }
}

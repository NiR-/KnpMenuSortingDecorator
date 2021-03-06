<?php

namespace NiR\Menu\Tests\Renderer;

use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Matcher\MatcherInterface;
use NiR\Menu\Renderer\SortingRenderer;
use NiR\Menu\Util\MenuManipulator;

class SortingRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Knp\Menu\Renderer\RendererInterface
     */
    protected $renderer;

    /**
     * @var MatcherInterface
     */
    private $matcher;

    protected function setUp()
    {
        parent::setUp();

        $this->matcher = new Matcher();
        $this->renderer =  new SortingRenderer(
            new ListRenderer($this->matcher, array('compressed' => true)),
            new MenuManipulator()
        );
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->renderer = null;
    }

    public function testPrettyRendering()
    {
        $factory = new MenuFactory();
        $menu    = $factory->createItem('Root li', array('childrenAttributes' => array('class' => 'root')));
        $menu->addChild('Parent 1', array('extras' => array('weight' => 10)));
        $menu->addChild('Parent 2');

        $rendered = <<<HTML
<ul class="root">
  <li class="first">
    <span>Parent 2</span>
  </li>
  <li class="last">
    <span>Parent 1</span>
  </li>
</ul>

HTML;

        $this->assertEquals($rendered, $this->renderer->render($menu, array('compressed' => false, 'depth' => 1)));
    }
}

<?php
namespace Tests\Darrigo\WpPluginUtils\Service;

use Darrigo\WpPluginUtils\Model\Collection;
use Darrigo\WpPluginUtils\View\View;
use PHPUnit\Framework\TestCase;

/**
 * Class ViewTest
 * @package Tests\Darrigo\WpPluginUtils\Service
 * @author Gabriele D'Arrigo - darrigo.g@gmail.com
 */
class ViewTest extends TestCase
{
    /**
     * @var string
     */
    protected $templatePath;

    /**
     * @var Collection
     */
    protected $viewArgs;

    public function setUp()
    {
        $this->templatePath = dirname(dirname(dirname(__FILE__))) . '/fixtures/templates/_template.php';
        $this->viewArgs = new Collection(['hello' => 'Hello']);
    }

    public function testItShouldReturnTemplatePathAndViewArgs()
    {
        $view = new View($this->templatePath, $this->viewArgs);
        $this->assertEquals($this->templatePath, $view->getTemplatePath());
        $this->assertEquals($this->viewArgs, $view->getViewArgs());
    }

    public function testItShouldRenderATemplate()
    {
        $view = new View($this->templatePath, $this->viewArgs);
        ob_start();
        $view->render();
        $rendered = ob_get_clean();

        $this->assertEquals('<p>Hello world!</p>', $rendered);
    }

    public function testItShouldThrowAnExceptionIfTemplateIsNotFound()
    {
        $templatePath = dirname(dirname(dirname(__FILE__))) . '/fixtures/templates/templateXXX.php';
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(View::class . ' cannot found template ' . $templatePath);

        $view = new View($templatePath, $this->viewArgs);
        $view->render();
    }
}

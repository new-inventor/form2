<?php
/**
 * Created by PhpStorm.
 * User: inventor
 * Date: 04.04.2016
 * Time: 20:15
 */

namespace NewInventor\Form\Renderer;


use DeepCopy\DeepCopy;
use NewInventor\Abstractions\Interfaces\ObjectInterface;
use NewInventor\ConfigTool\Config;
use NewInventor\Form\Interfaces\BlockInterface;
use NewInventor\Form\Interfaces\FieldInterface;
use NewInventor\Form\Renderer\Traits;
use NewInventor\Template\Template;

/**
 * Class BlockRenderer
 * @package NewInventor\Form\Renderer
 */
class BlockRenderer extends BaseRenderer
{
    use Traits\Errors;
    use Traits\Label;
    use Traits\Children;
    use Traits\Repeatable;
    
    /** @inheritdoc */
    public function getString()
    {
        /** @var BlockInterface $block */
        if ($this->object->isRepeatable()) {
            $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'repeatBlock']);
        } elseif ($this->object->isRepeatableContainer()) {
            $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'repeatContainer']);
        } else {
            $templateStr = Config::get(['renderer', 'templates', $this->object->getTemplate(), 'block']);
        }
        
        $template = new Template($templateStr);
        
        return $template->getString($this);
    }
    
    /**
     * @return string
     */
    public function repeatScript()
    {
        $deepCopy = new DeepCopy();
        /** @var BlockInterface|FieldInterface|RenderableInterface $childCopy */
        $childCopy = $deepCopy->copy($this->object->getRepeatObject());
        $childCopy->clear();
        $childCopy->setParent($this->object);
        /** @var BlockInterface|FieldInterface $child */
        $child = $this->object->child(0);
        $res = '<script>
$(document).ready(function(e){
    $("[' . $this->containerSelector() . ']").repeatContainer({
        containerSelector : \'[' . $this->containerSelector() . ']\',
        blockSelector : \'[' . $this->blockSelector() . ']\',
        actionsSelector : \'[' . $this->actionsBlockSelector() . '="' . $this->object->getName() . '"]\',
        addSelector : \'[' . $this->addActionSelector() . ']\',
        deleteSelector : \'[' . $this->deleteActionSelector() . ']\',
        dummyObject: \'' . $childCopy . '\',
        addButton: \'' . $this->addButton(false) . '\',
        deleteButton: \'' . $this->deleteButton(false) . '\',
        fullActionsBlock: \'' . $this->actions(false) . '\'
    });
});
</script>';
        
        return $res;
    }
}
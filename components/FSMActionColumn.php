<?php

namespace common\components;

use Yii;
//use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use kartik\grid\ActionColumnAsset;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\icons\Icon;

use common\components\FSMAccessHelper;

class FSMActionColumn extends \kartik\grid\ActionColumn
{
    use \common\traits\BootstrapValidationTrait;

    public $linkedObj = null;
    public $dropdownDefaultBtn = '';
    public $isDropdownActionColumn = false;
    public $checkCanDo = false;
    public $checkPermission = false;
    public $permissionClass = '';
    public $pullLeft = true;
    public $additionalOptions = [];
    //public $defaultCssClass = 'btn btn-xs';
    public $defaultCssClass = 'btn';
    public $btnSize = '';

    /*
    public function init()
    {
        parent::init();
        $this->getBootstrapVersion();
        Icon::map($this->grid->getView(), Icon::FA);
        Html::addCssClass($this->additionalOptions, $this->defaultCssClass);
    }
     * 
     */

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->initColumnSettings([
            'hiddenFromExport' => true,
            'mergeHeader' => true,
            'hAlign' => GridView::ALIGN_CENTER,
            'vAlign' => GridView::ALIGN_MIDDLE,
            'width' => '50px',
        ]);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->_isDropdown = ($this->grid->bootstrap && $this->dropdown);
        if (!isset($this->header)) {
            $this->header = Yii::t('kvgrid', 'Actions');
        }
        $this->parseFormat();
        $this->parseVisibility();
        
        yii\grid\ActionColumn::init();
        $this->setPageRows();
        
        $this->getBootstrapVersion();
        Icon::map($this->grid->getView(), Icon::FA);
        Html::addCssClass($this->contentOptions, 'action-column');
    }
    
    private function getLinkedObjParam()
    {
        $linkedObj = isset($this->linkedObj) ? $this->linkedObj : null;
        if (is_array($linkedObj)) {
            $arr = [];
            foreach ($linkedObj as $obj) {
                if (!empty($obj['fieldName']) && !empty($obj['id'])) {
                    $arr[] = "{$obj['fieldName']}={$obj['id']}";
                }
            }
            $result = !empty($arr) ? "&" . implode("&", $arr) : '';
        } else {
            $result = (isset($linkedObj) ? "&{$linkedObj['fieldName']}={$linkedObj['id']}" : '');
        }
        return $result;
    }

    /**
     * Sets a default button configuration based on the button name (bit different than [[initDefaultButton]] method)
     *
     * @param string $name button name as written in the [[template]]
     * @param string $title the title of the button
     * @param string $icon the meaningful suffix name for the button
     */
    protected function setDefaultButton($name, $title, $icon)
    {
        if (isset($this->buttons[$name])) {
            return;
        }
        if ($this->isDropdownActionColumn) {
            return;
        }

        //$isBs4 = $this->grid->isBs4();
        $isBs4 = false;

        $opts = "{$name}Options";

        if (!$this->_isDropdown) {
            $this->defaultCssClass = !empty($btnSize = ArrayHelper::remove($this->additionalOptions, 'size', '')) ? $this->defaultCssClass . ' btn-' . $btnSize : $this->defaultCssClass;
            Html::addCssClass($this->additionalOptions, $this->defaultCssClass);

            switch ($name) {
                case 'view':
                    $this->buttons['view'] = function (array $params) use ($opts, $title, $icon) {
                        extract($params);

                        if ($this->checkPermission) {
                            $modelClass = !empty($this->permissionClass) ? $this->permissionClass : \yii\helpers\StringHelper::basename(get_class($model));
                            if (!FSMAccessHelper::can('view' . $modelClass, $model)) {
                                return null;
                            }
                        } elseif ($this->checkCanDo && !$model->canView()) {
                            return null;
                        }

                        $title = !empty($title) ? $title : Yii::t('kvgrid', 'View');
                        $icon = Icon::show((!empty($icon) ? $icon : 'eye'));
                        
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                        ], $this->additionalOptions, $this->buttonOptions);
                
                        if (empty($this->viewOptions['noTarget']) && empty($this->linkedObj)) {
                            $options['target'] = '_blank';
                        }
                        Html::addCssClass($options, 'btn-info');
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        $label = ArrayHelper::remove($options, 'label', $icon);
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        return $link;
                    };
                    break;

                case 'update':
                    $this->buttons['update'] = function (array $params) use ($opts, $title, $icon) {
                        extract($params);

                        if ($this->checkPermission) {
                            $modelClass = !empty($this->permissionClass) ? $this->permissionClass : \yii\helpers\StringHelper::basename(get_class($model));
                            if (!FSMAccessHelper::can('update' . $modelClass, $model)) {
                                return null;
                            } elseif (!$model->canUpdate()) {
                                return null;
                            }
                        } elseif ($this->checkCanDo && !$model->canUpdate()) {
                            return null;
                        }

                        $title = !empty($title) ? $title : Yii::t('common', 'Edit');
                        $icon = Icon::show((!empty($icon) ? $icon : 'pencil-alt'));
                        
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                        ], $this->additionalOptions, $this->buttonOptions);
                
                        Html::addCssClass($options, 'btn-primary');
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        $label = ArrayHelper::remove($options, 'label', $icon);
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        return $link;
                    };
                    break;

                case 'delete':
                    $this->buttons['delete'] = function (array $params) use ($opts, $title, $icon) {
                        extract($params);

                        if ($this->checkPermission) {
                            $modelClass = !empty($this->permissionClass) ? $this->permissionClass : \yii\helpers\StringHelper::basename(get_class($model));
                            if (!FSMAccessHelper::can('delete' . $modelClass, $model)) {
                                return null;
                            } elseif (!$model->canDelete()) {
                                return null;
                            }
                        } elseif ($this->checkCanDo && !$model->canDelete()) {
                            return null;
                        }

                        $title = !empty($title) ? $title : Yii::t('kvgrid', 'Delete');
                        $icon = Icon::show((!empty($icon) ? $icon : 'trash'));
                        
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                        ], $this->additionalOptions, $this->buttonOptions);
                
                        Html::addCssClass($options, 'btn-danger');
                        $item = $this->grid->itemLabelSingle ?? Yii::t('kvgrid', 'item');
                        $message = Yii::t('kvgrid', 'Are you sure you want to remove this {item}?', ['item' => $item]);
                        if ($this->grid->pjax) {
                            $pjaxContainer = $this->grid->pjaxSettings['options']['id'];
                            $css = $this->grid->options['id'] . '-action-del';
                            Html::addCssClass($options, $css);
                            $view = $this->grid->getView();
                            $delOpts = Json::encode([
                                'css' => $css,
                                'pjax' => true,
                                'pjaxContainer' => $pjaxContainer,
                                'lib' => ArrayHelper::getValue($this->grid->krajeeDialogSettings, 'libName', 'krajeeDialog'),
                                'msg' => $message,
                            ]);
                            $js = "fsmDialogAction({$delOpts});";
                            $view->registerJs($js);
                            $this->initPjax($js);
                            $options['data-pjax-container'] = $pjaxContainer;
                        } else {
                            $options['data-method'] = 'post';
                            $options['data-confirm'] = $message;
                        }
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        $label = ArrayHelper::remove($options, 'label', $icon);
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        return $link;
                    };
                    break;

                default:
                    $this->buttons[$name] = function (array $params) use ($opts, $title, $icon) {
                        extract($params);

                        $options = ['title' => $title, 'aria-label' => $title, 'data-pjax' => '0'];
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        $label = $this->renderLabel($options, $title, ['class' => "glyphicon glyphicon-{$icon}"]);
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        return $link;
                    };
                    break;
            }
        } else {
            
            //Html::addCssClass($this->additionalOptions, $this->defaultCssClass);
            
            switch ($name) {
                case 'view':
                    $this->buttons['view'] = function (array $params) use ($opts, $title, $icon, $isBs4) {
                        extract($params);

                        if ($this->checkPermission) {
                            $modelClass = !empty($this->permissionClass) ? $this->permissionClass : \yii\helpers\StringHelper::basename(get_class($model));
                            if (!FSMAccessHelper::can('view' . $modelClass, $model)) {
                                return null;
                            }
                        } elseif ($this->checkCanDo && !$model->canView()) {
                            return null;
                        }

                        $title = !empty($title) ? $title : Yii::t('kvgrid', 'View');
                        $icon = Icon::show((!empty($icon) ? $icon : 'eye'));
                        $isDropdown = $this->_isDropdown && !$isBtn;
                        $btnSize = ArrayHelper::getValue($this->additionalOptions, 'size', '');

                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                        ], $this->additionalOptions);

                        if ($isBtn && !empty($btnSize)) {
                            Html::addCssClass($options, ' btn-' . $btnSize);
                        }

                        if (!$isDropdown) {
                            Html::addCssClass($options, 'btn-info');
                        }
                        if (empty($this->viewOptions['noTarget']) && empty($this->linkedObj)) {
                            $options['target'] = '_blank';
                        }
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        if ($isDropdown) {
                            $options['tabindex'] = '-1';
                        }                        
                        $label = ArrayHelper::remove($options, 'label', ($isDropdown ? $icon . ' ' . $title : $icon));
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        if ($isDropdown) {
                            return $isBs4 ? $link : "<li>{$link}</li>\n";
                        } else {
                            return $link;
                        }
                    };
                    break;

                case 'update':
                    $this->buttons['update'] = function (array $params) use ($opts, $title, $icon, $isBs4) {
                        extract($params);

                        if ($this->checkPermission) {
                            $modelClass = !empty($this->permissionClass) ? $this->permissionClass : \yii\helpers\StringHelper::basename(get_class($model));
                            if (!FSMAccessHelper::can('update' . $modelClass, $model)) {
                                return null;
                            } elseif (!$model->canUpdate()) {
                                return null;
                            }
                        } elseif ($this->checkCanDo && !$model->canUpdate()) {
                            return null;
                        }

                        $title = !empty($title) ? $title : Yii::t('common', 'Edit');
                        $icon = Icon::show((!empty($icon) ? $icon : 'pencil-alt'));
                        $isDropdown = $this->_isDropdown && !$isBtn;
                        $btnSize = ArrayHelper::getValue($this->additionalOptions, 'size', '');

                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                        ], $this->additionalOptions);

                        if ($isBtn && !empty($btnSize)) {
                            Html::addCssClass($options, ' btn-' . $btnSize);
                        }

                        if (!$isDropdown) {
                            Html::addCssClass($options, 'btn-primary');
                        }
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        if ($isDropdown) {
                            $options['tabindex'] = '-1';
                        }
                        $label = ArrayHelper::remove($options, 'label', ($isDropdown ? $icon . ' ' . $title : $icon));
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        if ($isDropdown) {
                            return $isBs4 ? $link : "<li>{$link}</li>\n";
                        } else {
                            return $link;
                        }
                    };
                    break;

                case 'delete':
                    $this->buttons['delete'] = function (array $params) use ($opts, $title, $icon, $isBs4) {
                        extract($params);

                        if ($this->checkPermission) {
                            $modelClass = !empty($this->permissionClass) ? $this->permissionClass : \yii\helpers\StringHelper::basename(get_class($model));
                            if (!FSMAccessHelper::can('delete' . $modelClass, $model)) {
                                return null;
                            } elseif (!$model->canDelete()) {
                                return null;
                            }
                        } elseif ($this->checkCanDo && !$model->canDelete()) {
                            return null;
                        }

                        $isDropdown = $this->_isDropdown && !$isBtn;
                        $title = !empty($title) ? $title : Yii::t('kvgrid', 'Delete');
                        $icon = Icon::show((!empty($icon) ? $icon : 'trash'));
                        $btnSize = ArrayHelper::getValue($this->additionalOptions, 'size', '');

                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                        ], $this->additionalOptions);

                        if ($isBtn && !empty($btnSize)) {
                            Html::addCssClass($options, ' btn-' . $btnSize);
                        }

                        if (!$isDropdown) {
                            Html::addCssClass($options, 'btn-danger');
                        }
                        $item = $this->grid->itemLabelSingle ?? Yii::t('kvgrid', 'item');
                        $message = Yii::t('kvgrid', 'Are you sure you want to remove this {item}?', ['item' => $item]);
                        if ($this->grid->pjax) {
                            $pjaxContainer = $this->grid->pjaxSettings['options']['id'];
                            $css = $this->grid->options['id'] . '-action-del';
                            Html::addCssClass($options, $css);
                            $view = $this->grid->getView();
                            $delOpts = Json::encode([
                                'css' => $css,
                                'pjax' => true,
                                'pjaxContainer' => $pjaxContainer,
                                'lib' => ArrayHelper::getValue($this->grid->krajeeDialogSettings, 'libName', 'krajeeDialog'),
                                'msg' => $message,
                            ]);
                            $js = "fsmDialogAction({$delOpts});";
                            $view->registerJs($js);
                            $this->initPjax($js);
                            $options['data-pjax-container'] = $pjaxContainer;
                        } else {
                            $options['data-method'] = 'post';
                            $options['data-confirm'] = $message;
                        }
                        $options = ArrayHelper::merge($options, $this->buttonOptions, $this->$opts);
                        if ($isDropdown) {
                            $options['tabindex'] = '-1';
                        }                        
                        $label = ArrayHelper::remove($options, 'label', ($isDropdown ? $icon . ' ' . $title : $icon));
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        if ($isDropdown) {
                            return $isBs4 ? $link : "<li>{$link}</li>\n";
                        } else {
                            return $link;
                        }
                    };
                    break;

                default:
                    $this->buttons[$name] = function ($url) use ($opts, $title, $icon) {
                        $linkedObjParam = $this->getLinkedObjParam();

                        $options = ['title' => $title, 'aria-label' => $title, 'data-pjax' => '0'];
                        $options = array_replace_recursive($options, $this->buttonOptions, $this->$opts);
                        $label = $this->renderLabel($options, $title, ['class' => "glyphicon glyphicon-{$icon}"]);
                        $link = Html::a($label, $url . $linkedObjParam, $options);
                        $options['tabindex'] = '-1';
                        return "<li>{$link}</li>\n";
                    };
                    break;
            }
        }
    }

    /**
     * Render default action buttons
     *
     * @return string
     */
    protected function initDefaultButtons()
    {
        $this->setDefaultButton('view', '', '');
        $this->setDefaultButton('update',  '', '');
        $this->setDefaultButton('delete',  '', '');
    }

    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        $linkedObjParam = $this->getLinkedObjParam();
        if (!$this->_isDropdown) {
            return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index, $linkedObjParam) {
                $name = $matches[1];

                if (isset($this->visibleButtons[$name])) {
                    $isVisible = $this->visibleButtons[$name] instanceof \Closure ? call_user_func($this->visibleButtons[$name], [
                        'model' => $model,
                        'key' => $key,
                        'index' => $index,
                        'linkedObjParam' => $linkedObjParam,
                        'isBtn' => true,
                        'isDropdown' => $this->_isDropdown,
                    ]) : $this->visibleButtons[$name];
                } else {
                    $isVisible = true;
                }

                if ($isVisible && isset($this->buttons[$name])) {
                    $url = $this->createUrl($name, $model, $key, $index);
                    return call_user_func($this->buttons[$name], [
                        'url' => $url,
                        'model' => $model,
                        'key' => $key,
                        'linkedObjParam' => $linkedObjParam,
                        'isBtn' => true,
                        'isDropdown' => $this->_isDropdown,
                    ]);
                }

                return '';
            }, $this->template);
        } else {
            $template = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
                return $matches[1];
            }, $this->template);
            $btnArr = explode(' ', $template);

            $firstBtn = null;
            if ($defaultBtn = (!empty($this->dropdownDefaultBtn) ? $this->dropdownDefaultBtn : null)) {
                $url = $this->createUrl($defaultBtn, $model, $key, $index);
                $firstBtn = call_user_func($this->buttons[$defaultBtn], [
                    'url' => $url,
                    'model' => $model,
                    'key' => $key,
                    'linkedObjParam' => $linkedObjParam,
                    'isBtn' => true,
                    'isDropdown' => $this->_isDropdown,
                ]);
            }
            if ($defaultBtn && (count($btnArr) > 0) && (($btnKey = array_search($defaultBtn, $btnArr)) !== false)) {
                unset($btnArr[$btnKey]);
            }
            while (!$firstBtn && (count($btnArr) > 0)) {
                $defaultBtn = array_shift($btnArr);
                if (!empty($defaultBtn)) {
                    $url = $this->createUrl($defaultBtn, $model, $key, $index);
                    Html::addCssClass($this->additionalOptions, $this->defaultCssClass);
                    $firstBtn = call_user_func($this->buttons[$defaultBtn], [
                        'url' => $url,
                        'model' => $model,
                        'key' => $key,
                        'linkedObjParam' => $linkedObjParam,
                        'isBtn' => true,
                        'isDropdown' => $this->_isDropdown,
                    ]);
                    Html::removeCssClass($this->additionalOptions, $this->defaultCssClass);
                }
            }

            $content = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index, $linkedObjParam) {
                $name = $matches[1];

                if (isset($this->visibleButtons[$name])) {
                    $isVisible = $this->visibleButtons[$name] instanceof \Closure ? call_user_func($this->visibleButtons[$name], [
                        'url' => $url,
                        'model' => $model,
                        'key' => $key,
                        'linkedObjParam' => $linkedObjParam,
                        'isBtn' => false,
                        'isDropdown' => $this->_isDropdown,
                    ]) : $this->visibleButtons[$name];
                } else {
                    $isVisible = true;
                }

                if ($isVisible && isset($this->buttons[$name])) {
                    $url = $this->createUrl($name, $model, $key, $index);
                    return call_user_func($this->buttons[$name], [
                        'url' => $url,
                        'model' => $model,
                        'key' => $key,
                        'linkedObjParam' => $linkedObjParam,
                        'isBtn' => false,
                        'isDropdown' => $this->_isDropdown,
                    ]);
                } else {
                    return '';
                }
            }, $this->template);

            if (!empty(trim($content))) {
                //$isBs4 = $this->grid->isBs4();
                $isBs4 = false;
                if ($isBs4 && $this->_isDropdown) {
                    Html::addCssClass($this->buttonOptions, 'dropdown-item');
                }

                $options = $this->dropdownButton;
                if (is_callable($options)) {
                    $options = $options($model, $key, $index);
                }
                if (!isset($options['class'])) {
                    $options['class'] = 'btn ' . $this->grid->getDefaultBtnCss();
                }
                $label = ArrayHelper::remove($options, 'label', Yii::t('kvgrid', 'Actions'));
                $caret = $isBs4 ? '' : ArrayHelper::remove($options, 'caret', ' <span class="caret"></span>');
                $options = array_replace_recursive($options, ['type' => 'button', 'data-toggle' => 'dropdown']);
                Html::addCssClass($options, 'dropdown-toggle');
                $button = Html::button($label . $caret, $options);
                Html::addCssClass($this->dropdownMenu, 'dropdown-menu');
                if ($this->pullLeft) {
                    Html::addCssClass($this->dropdownMenu, 'pull-right');
                }
                $countBtn = substr_count($content, '</li>');
                if ($countBtn > 1) {
                    $dropdown = $button . PHP_EOL . Html::tag($isBs4 ? 'div' : 'ul', $content, $this->dropdownMenu);
                } else {
                    $dropdown = '';
                }
                Html::addCssClass($this->dropdownOptions, $isBs4 ? 'btn-group' : 'dropdown');

                $buttonGroupClass = ($this->isBs4 ? 'yii\bootstrap4\ButtonGroup' : 'yii\bootstrap\ButtonGroup');
                $buttonGroup = $buttonGroupClass::widget([
                    'options' => ['class' => 'btn-group-sm'],
                    'buttons' => [
                        $firstBtn,
                        $dropdown,
                    ],
                ]);
                return Html::tag('div', $buttonGroup, $this->dropdownOptions);
            }
            return $content;
        }
    }

}

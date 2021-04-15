<?php

class Aghayevi_Storefinder_Adminhtml_Storefinder_PoiController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init layout, menu and breadcrumb
     *
     * @return $this
     */
    protected function _initAction()
    {

        $this->loadLayout()
            ->_setActiveMenu('storefinder')
            ->_addBreadcrumb($this->__('Aghayevi'), $this->__('Storefinder'));
        return $this;
    }

    /**
     * Storefinder Index, renders grid
     */
    public function indexAction()
    {
        $this->_initAction();
        // ->_addContent($this->getLayout()->createBlock('storefinder/adminhtml_poi'));
        $this->renderLayout();
        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', null);

        $model = Mage::getModel('storefinder/poi');

        if ($id) {
            $model->load((int) $id);

            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setPoiId($id);
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storefinder')->__('Storefinder POI does not exist'));
                $this->_redirect('*/*/');
            }
        }

        Mage::register('storefinder_poi_data', $model);

        $this->_title($this->__('Storefinder'))->_title($this->__('Edit POI'));
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
     //   $this->_addContent($this->getLayout()->createBlock('storefinder/adminhtml_poi_edit'));
        $this->renderLayout();
    }

    /**
     * Storefinder Grid
     *
     * @return $this
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('storefinder/adminhtml_poi_grid')->toHtml()
        );

        return $this;
    }

    /**
     * Storefinder Products Grid
     *
     * @return $this
     */
    public function productsAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('storefinder/adminhtml_poi_edit_tab_products')->toHtml()
        );

        return $this;
    }

    public function saveAction()
    {

        if ($data = $this->getRequest()->getPost())
        {
            $model = Mage::getModel('storefinder/poi');
            $id = $this->getRequest()->getParam('id');

            foreach ($data as $key => $value)
            {
                if (is_array($value))
                {
                    $data[$key] = implode(',',$this->getRequest()->getParam($key));
                }
            }

            if ($id) {
                $model->load($id);
            }
            $model->setData($data);

            Mage::getSingleton('adminhtml/session')->setFormData($data);

            try {
                if ($id) {
                    $model->setId($id);
                }
                $model->save();

                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('storefinder')->__('Error saving POI'));
                }

                // Save POI Products
                if (!empty($data['product_id']))
                {

                    $productModel = Mage::getModel('storefinder/poi_product');

                    // Delete then create products every time?
                    $foundProducts = $productModel->getCollection()
                        ->addFieldToFilter('poi_id', $id)
                        ->addFieldToFilter('product_id', array('nin' => $data['product_id']));
                    foreach ($foundProducts as $foundProduct) {
                        $foundProduct->delete();
                    }

                    foreach (explode(',', $data['product_id']) as $productId) {

                        $newPOIProduct = $productModel->loadProduct($productId, $id);

                        if (!$newPOIProduct->getId()) {
                            $newPOIProduct = Mage::getModel('storefinder/poi_product');
                            $newPOIProduct->setData('poi_id', $id);
                            $newPOIProduct->setData('product_id', $productId);
                            $newPOIProduct->save();
                        }
                    }

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storefinder')->__('POI with products were successfully saved.'));
                }
                else {
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storefinder')->__('POI was successfully saved.'));

                }

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            }

            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('storefinder')->__('No data found to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('storefinder/poi');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('storefinder')->__('The POI has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the POI to delete.'));
        $this->_redirect('*/*/');
    }
}
<?php

class ControllerPaymentCubepay extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('payment/cubepay');
        $this->load->model('payment/cubepay');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cubepay', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/cubepay', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('payment/cubepay', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'] . '&type=payment', true);

        //form 項目
        $data['entry_url'] = $this->language->get('entry_url');
        $data['entry_payment_client_id'] = $this->language->get('entry_payment_client_id');
        $data['entry_payment_client_secret'] = $this->language->get('entry_payment_client_secret');
        $data['entry_fiat'] = $this->language->get('entry_fiat');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['text_cubepay_url'] = $this->language->get('text_cubepay_url');
        $data['text_client_id'] = $this->language->get('text_client_id');
        $data['text_client_secret'] = $this->language->get('text_client_secret');
        $data['text_only_support_one_currency'] = $this->language->get('text_only_support_one_currency');
        $data['text_client_secret'] = $this->language->get('text_client_secret');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_only_support_one_currency'] = $this->language->get('text_only_support_one_currency');

        $fiats = $this->model_payment_cubepay->getFiat();
        if ($fiats['status'] == 200) {
            usort($fiats['data'], array($this, 'usortTest'));
        }
        $data['fiats'] = $fiats['data'];

        if (isset($this->request->post['cubepay_url'])) {
            $data['cubepay_url'] = $this->request->post['cubepay_url'];
        } else {
            $data['cubepay_url'] = $this->config->get('cubepay_url');
        }

        if (isset($this->request->post['cubepay_client_id'])) {
            $data['cubepay_client_id'] = $this->request->post['cubepay_client_id'];
        } else {
            $data['cubepay_client_id'] = $this->config->get('cubepay_client_id');
        }

        if (isset($this->request->post['cubepay_client_secret'])) {
            $data['cubepay_client_secret'] = $this->request->post['cubepay_client_secret'];
        } else {
            $data['cubepay_client_secret'] = $this->config->get('cubepay_client_secret');
        }

        if (isset($this->request->post['cubepay_fiat'])) {
            $data['cubepay_fiat'] = $this->request->post['cubepay_fiat'];
        } else {
            $data['cubepay_fiat'] = $this->config->get('cubepay_fiat');
        }

        if (isset($this->request->post['cubepay_status'])) {
            $data['cubepay_status'] = $this->request->post['cubepay_status'];
        } else {
            $data['cubepay_status'] = $this->config->get('cubepay_status');
        }

        if (isset($this->request->post['cubepay_sort_order'])) {
            $data['cubepay_sort_order'] = $this->request->post['cubepay_sort_order'];
        } else {
            $data['cubepay_sort_order'] = $this->config->get('cubepay_sort_order');
        }

        if (isset($this->request->post['cubepay_currency'])) {
            $data['cubepay_currency'] = $this->request->post['cubepay_currency'];
        } else {
            $data['cubepay_currency'] = $this->config->get('cubepay_currency');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('payment/cubepay.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/cubepay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['cubepay_client_id']) {
            $this->error['warning'] = $this->language->get('error_empty') . $this->language->get('entry_payment_client_id');
        }

        if (!$this->request->post['cubepay_client_secret']) {
            $this->error['warning'] = $this->language->get('error_empty') . $this->language->get('entry_payment_client_secret');
        }

        if (!$this->request->post['cubepay_url']) {
            $this->error['warning'] = $this->language->get('error_empty') . $this->language->get('entry_url');
        }

        return !$this->error;
    }

    private static function usortTest($a, $b)
    {
        return strnatcmp($a['name'], $b['name']);
    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/PDF_Signature.php');

abstract class App_pdf extends TCPDF
{
    use PDF_Signature;
    public $contract = [];
    public $font_size = '';

    public $font_name = '';

    public $image_scale = 1.53;

    public $jpeg_quaility = 100;

    public $pdf_author = '';

    public $swap = false;

    public $footerY = -15;

    protected $languageArray = [
        'a_meta_charset' => 'UTF-8',
    ];

    protected $tag = '';

    protected $view_vars = [];

    private $formatArray = [];

    /**
     * This is true when last page is rendered
     * @var boolean
     */
    protected $last_page_flag = false;

    protected $ci;

    public function __construct($contract=[])
    {
        $this->contract=$contract;
        $this->formatArray = $this->get_format_array();

        parent::__construct($this->formatArray['orientation'], 'mm', $this->formatArray['format'], true, 'UTF-8', false, false);

        /**
         * If true print TCPDF meta link.
         * @protected
         * @since 2.3.2
         */
        $this->tcpdflink = false;

        $this->ci = &get_instance();

        $this->setLanguageArray($this->languageArray);

        $this->swap       = get_option('swap_pdf_info');
        $this->pdf_author = get_option('companyname');

        $this->set_font_size($this->get_default_font_size());
        $this->set_font_name($this->get_default_font_name());

        if (defined('APP_PDF_MARGIN_LEFT') && defined('APP_PDF_MARGIN_TOP') && defined('APP_PDF_MARGIN_RIGHT')) {
            $this->SetMargins(APP_PDF_MARGIN_LEFT, APP_PDF_MARGIN_TOP, APP_PDF_MARGIN_RIGHT);
        }

        $this->SetAutoPageBreak(true, (defined('APP_PDF_MARGIN_BOTTOM') ? APP_PDF_MARGIN_BOTTOM : PDF_MARGIN_BOTTOM));

        $this->SetAuthor($this->pdf_author);
        $this->SetFont($this->get_font_name(), '', $this->get_font_size());
        $this->setImageScale($this->image_scale);
        $this->setJPEGQuality($this->jpeg_quaility);

        $this->AddPage($this->formatArray['orientation'], $this->formatArray['format']);

        if ($this->ci->input->get('print') == 'true') {
            // force print dialog
            $this->IncludeJS('print(true);');
        }

        $this->set_default_view_vars();

        hooks()->do_action('pdf_construct', ['pdf_instance' => $this, 'type' => $this->type()]);
    }

    abstract public function prepare();

    abstract protected function file_path();

    abstract protected function type();

    public function set_view_vars($vars, $value = null)
    {
        if (is_null($value) && is_array($vars)) {
            $this->view_vars = array_merge($this->view_vars, $vars);
        } else {
            $this->view_vars[$vars] = $value;
        }

        return $this;
    }

    public function get_view_vars($var = null)
    {
        if(array_key_exists($var, $this->view_vars)) {
            return $this->view_vars[$var];
        }

        return $this->view_vars;
    }

    public function get_format_array()
    {
        return get_pdf_format('pdf_format_' . $this->type());
    }

    public function set_font_size($size)
    {
        $this->font_size = $size;

        return $this;
    }

    public function get_font_size()
    {
        return $this->font_size;
    }

    public function get_default_font_size()
    {
        $font_size = get_option('pdf_font_size');

        if ($font_size == '') {
            $font_size = 10;
        }

        return $font_size;
    }

    public function get_font_name()
    {
        return $this->font_name;
    }

    public function set_font_name($name)
    {
        $this->font_name = $name;

        return $this;
    }

    public function get_default_font_name()
    {
        $font = get_option('pdf_font');
        if ($font != '' && !in_array($font, get_pdf_fonts_list())) {
            $font = 'freesans';
        }

        return $font;
    }

    public function custom_fields()
    {
        $whereCF = ['show_on_pdf' => 1];
        if (is_custom_fields_for_customers_portal()) {
            $whereCF['show_on_client_portal'] = 1;
        }

        return get_custom_fields($this->type(), $whereCF);
    }

    public function isLastPage()
    {
        return $this->last_page_flag;
    }

    public function Close()
    {
        if (hooks()->apply_filters('process_pdf_signature_on_close', true)) {
            //$this->processSignature();
            /*$path   = $this->getSignaturePath();
            if (!empty($path) && file_exists($path)) {
                $signature = '';
                if ($this->type() == 'contract') {
                    $imageData = file_get_contents($path);
                    $signature .= '<br /><img src="'.$imageData.'" style="width:200px;height:75px;"><br /><span style="font-weight:bold;text-align: right;">';
                    //$signature .= _l('contract_signed_by') . ": {$record->acceptance_firstname} {$record->acceptance_lastname}<br />";
                    $signature .= 'Date : ' . _dt($record->acceptance_date) . '&nbsp;&nbsp;';
                    $signature .= "IP: {$record->acceptance_ip}";
                    $signature .= '</span><br />';
                }
            }*/
        }
        
        hooks()->do_action('pdf_close', ['pdf_instance' => $this, 'type' => $this->type()]);

        $this->last_page_flag = true;

        parent::Close();
    }

    public function Header()
    {
        hooks()->do_action('pdf_header', ['pdf_instance' => $this, 'type' => $this->type()]);
    }

    public function Footer()
    {
        // Position from bottom
        $this->SetY($this->footerY);

        $this->SetFont($this->get_font_name(), '', $this->get_font_size());

        hooks()->do_action('pdf_footer', ['pdf_instance' => $this, 'type' => $this->type()]);

        if (get_option('show_page_number_on_pdf') == 1) {
            $this->SetFont($this->get_font_name(), 'I', 8);
            $this->SetTextColor(142, 142, 142);
            $this->Cell(0, 15, $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    public function fix_editor_html($content)
    {
        // Add <br /> tag and wrap over div element every image to prevent overlaping over text
        $content = preg_replace('/(<img[^>]+>(?:<\/img>)?)/i', '<div>$1</div>', $content);
        // Fix BLOG images from TinyMCE Mobile Upload, could help with desktop too
        $content = preg_replace('/data:image\/jpeg;base64/m', '@', $content);

        // Replace <img src="" width="100%" height="auto">
        $content = preg_replace('/width="(([0-9]*%)|auto)"|height="(([0-9]*%)|auto)"/mi', '', $content);

        // Add cellpadding to all tables inside the html
        $content = preg_replace('/(<table\b[^><]*)>/i', '$1 cellpadding="4">', $content);

        // Remove white spaces cased by the html editor ex. <td>  item</td>
        $content = preg_replace('/[\t\n\r\0\x0B]/', '', $content);
        $content = preg_replace('/([\s])\1+/', ' ', $content);

        // Tcpdf does not support float css we need to adjust this here
        $content = str_replace('float: right', 'text-align: right', $content);
        $content = str_replace('float: left', 'text-align: left', $content);

        // Tcpdf does not support float css we need to adjust this here
        $content = str_replace('float: right', 'text-align: right', $content);
        $content = str_replace('float: left', 'text-align: left', $content);

        // Image center
        
        $content = str_replace('margin-left: auto; margin-right: auto;', 'text-align:center;', $content);
        if (hooks()->apply_filters('process_pdf_signature_on_close', true)) {
            //$this->processSignature();
            $path   = $this->getSignaturePath();
            if (!empty($path) && file_exists($path)) {
                $record = $this->getSignatureableInstance();
                $signature = '';
                if ($this->type() == 'contract') {
                    $imageData = base64_encode(file_get_contents($path));
                    $src = 'data: image/png;base64,'.$imageData;
                    $instance = $this->getSignatureableInstance();
                    $signature .= '<br /><img src="'.site_url().'uploads/contracts/'.$instance->id.'/'.$instance->signature.'" data-imgsrc="'.$src.'" style="width:200px;height:75px;"><br /><span style="font-weight:bold;text-align: left;">';
                    //$signature .= _l('contract_signed_by') . ": {$record->acceptance_firstname} {$record->acceptance_lastname}<br />";
                    $signature .= 'Date : ' . _dt($record->acceptance_date) . '&nbsp;&nbsp;';
                    $signature .= "&nbsp;&nbsp;IP: {$record->acceptance_ip}";
                    $signature .= '</span><br />';
                    //echo $signature;die();
                    $content = str_replace('{{CUSTOMER__SIGNATURE}}', $signature, $content);
                    $content = str_replace('{{CUSTOMER_SIGNATURE}}', $signature, $content);
                }
            }
            if ($this->type() == 'contract') {
                $_staff_user_id = $this->contract->addedfrom;
                $staff = get_staff($_staff_user_id);
                $CONTRACTOR__SIGNATURE_IMAGE = $staff->signature;
                $CONTRACTOR__SIGNATURE='';
                if($CONTRACTOR__SIGNATURE_IMAGE!="" && file_exists(STAFF_UPLOADS_FOLDER.'/'.$_staff_user_id.'/'.$CONTRACTOR__SIGNATURE_IMAGE)){
                    $CONTRACTOR__SIGNATURE .= '<br /><img src="'.site_url().'uploads/staff/'.$_staff_user_id.'/'.$CONTRACTOR__SIGNATURE_IMAGE.'" data-imgsrc="'.$CONTRACTOR__SIGNATURE_IMAGE.'" style="width:200px;height:75px;"><br/>';
                
                    $record = $this->getSignatureableInstance();
                    if(isset($record->created_ip)){
                        $CONTRACTOR__SIGNATURE .='<span style="font-weight:bold;text-align: left;">';
                        $CONTRACTOR__SIGNATURE .= 'Date : ' . _dt($record->dateadded) . '&nbsp;&nbsp;';
                        $CONTRACTOR__SIGNATURE .= "&nbsp;&nbsp;IP: {$record->created_ip}";
                        $CONTRACTOR__SIGNATURE .= '</span><br />';
                    }
                    
                    $CONTRACTOR__SIGNATURE .= '<br/>';
                    $content = str_replace('{{CONTRACTOR__SIGNATURE}}', $CONTRACTOR__SIGNATURE, $content);
                    $content = str_replace('{{CONTRACTOR_SIGNATURE}}', $CONTRACTOR__SIGNATURE, $content);
                }
            } else {
                $staff = get_staff(get_staff_user_id());
                $CONTRACTOR__SIGNATURE_IMAGE=$staff->signature;
                $CONTRACTOR__SIGNATURE='';
                if($CONTRACTOR__SIGNATURE_IMAGE!="" && file_exists(STAFF_UPLOADS_FOLDER.'/'.get_staff_user_id().'/'.$CONTRACTOR__SIGNATURE_IMAGE)){
                    $CONTRACTOR__SIGNATURE .= '<br /><img src="'.site_url().'uploads/staff/'.get_staff_user_id().'/'.$CONTRACTOR__SIGNATURE_IMAGE.'" data-imgsrc="'.$CONTRACTOR__SIGNATURE_IMAGE.'" style="width:200px;height:75px;"><br/>';
                    $CONTRACTOR__SIGNATURE .= '<br/>';
                    $content = str_replace('{{CONTRACTOR__SIGNATURE}}', $CONTRACTOR__SIGNATURE, $content);
                    $content = str_replace('{{CONTRACTOR_SIGNATURE}}', $CONTRACTOR__SIGNATURE, $content);
                }
            }
        }
        
        //$content = str_replace('{{LOGO_IMAGE}}', "https://www.hashevo.com/elightsolar/elite.png", $content);
        if ($this->type() == 'contract') {
            $content = str_replace('{{AGR_MFG_WRNTY}}', $this->contract->manufacturer_warranty, $content);
            $content = str_replace('{{AGR_RYARD}}', $this->contract->roll_yard, $content);
            $content = str_replace('{{AGR_SHINGLE_CLR}}', $this->contract->shingle_color, $content);
            $content = str_replace('{{AGR_VENTILATION}}', $this->contract->ventilation, $content);
            $content = str_replace('{{AGR_INSTL_DECKING}}', $this->contract->install_decking, $content);
            $content = str_replace('{{AGR_FASTNERS}}', $this->contract->fastners, $content);
            $content = str_replace('{{AGR_EXTRA_WORK_AND_NOTES}}', $this->contract->description, $content);

            /*Replace workorder variables*/
            $staff=get_staff(get_staff_user_id());
            
            $custName = $custEmail = $custAdd = $custAddOnly = $custAddCSZ = '';
            if($this->contract->rel_type == 'customer'){
                $clientDet = $this->contract->client_detail;
                $custName = $clientDet->company;
                $this->ci->load->model('clients_model');
                $hasContact = $this->ci->clients_model->get_contacts($this->contract->rel_id,array('active'=>1));
                if($hasContact && count($hasContact) > 0){
                    $custEmail = $hasContact[0]['email'];
                }
                $custAdd = ucwords($clientDet->billing_street.', '.$clientDet->billing_city.', '.$clientDet->billing_zip.', '.$clientDet->billing_state);
                $custAddOnly = ucwords($clientDet->billing_street);
                $custAddCSZ = ucwords($clientDet->billing_city.'/'.$clientDet->billing_state.'/'.$clientDet->billing_zip);
            } else {
                $leadDet = $this->contract->leadDetail;
                if($leadDet){
                    $custName = (isset($leadDet->name))?$leadDet->name.' '.$leadDet->leadlastname:'';
                    $custEmail = $leadDet->email;
                    $custAdd = ucwords($leadDet->address.', '.$leadDet->city.', '.$leadDet->zip.', '.$leadDet->state);
                    $custAddOnly = ucwords($leadDet->address);
                    $custAddCSZ = ucwords($leadDet->city.'/'.$leadDet->state.'/'.$leadDet->zip);
                }
            }
            $content = str_replace('{{CUSTOMER_NAME}}', $custName, $content);
            //$content = str_replace('{{CUSTOMER_PHONE}}', $client_detail->phonenumber, $content);
            $content = str_replace('{{CUSTOMER_ADDRESS}}', $custAdd, $content);

            $content = str_replace('{{REPRESENTATIVE_NAME}}', $staff->firstname.' '.$staff->lastname, $content);
            $content = str_replace('{{REPRESENTATIVE_PHONE}}', $staff->phonenumber, $content);

            $content = str_replace('{{ROOF_TYPE}}', $this->contract->roof_type, $content);
            $content = str_replace('{{LAYERS}}', $this->contract->layers, $content);
            $content = str_replace('{{PITCH}}', $this->contract->pitch, $content);

            $content = str_replace('{{ACV_RCV_TEXT}}', strtoupper($this->contract->acv_rcv), $content);
            
            $ad_allowance_plain = formatAmount($this->contract->ad_allowance, true);
            $ad_allowance_plain = $ad_allowance_plain?$ad_allowance_plain:0;
            $acv_rcv_plus_tax_plain = formatAmount($this->contract->acv_rcv_plus_tax, true);
            $acv_rcv_plus_tax_plain = $acv_rcv_plus_tax_plain?$acv_rcv_plus_tax_plain:0;
            $adv_cust_total = $ad_allowance_plain + $acv_rcv_plus_tax_plain;
            //$adv_cust_total = formatAmount($adv_cust_total);

            $ad_allowance = formatAmount($this->contract->ad_allowance);
            $acv_rcv_plus_tax = formatAmount($this->contract->acv_rcv_plus_tax);
            $content = str_replace('{{ACV_RCV_TAX}}', $this->contract->acv_rcv_plus_tax, $content);
            $content = str_replace('{{ADVERTISING_ALLOWANCE}}', $this->contract->ad_allowance, $content);
            $content = str_replace('{{CUSTOMER_TOTAL}}', $adv_cust_total, $content);

            $first_check_plain = formatAmount($this->contract->first_check, true);
            $first_check_plain = $first_check_plain ? $first_check_plain : 0;
            $first_check = formatAmount($this->contract->first_check);
            $second_check_plain = formatAmount($this->contract->second_check, true);
            $second_check_plain = $second_check_plain?$second_check_plain:0;
            $second_check = formatAmount($this->contract->second_check);
            $deductible_plain = formatAmount($this->contract->deductible, true);
            $deductible_plain = $deductible_plain?$deductible_plain:0;
            $deductible = $this->contract->deductible;
            $content = str_replace('{{FIRST_CHECK}}', $this->contract->first_check, $content);
            $content = str_replace('{{SECOND_CHECK}}', $this->contract->second_check, $content);
            $tot_to_collect = $first_check_plain + $second_check_plain - $deductible_plain;
            //$tot_to_collect = formatAmount($tot_to_collect);
            $content = str_replace('{{DEDUCTIBLE}}', $deductible, $content);
            $content = str_replace('{{TOTAL_TO_COLLECT}}', $tot_to_collect, $content);
            
            $content = str_replace('{{SOFFIT}}', $this->contract->soffit, $content);
            $content = str_replace('{{FASCIA}}', $this->contract->fascia, $content);
            $content = str_replace('{{SIDE_WALL}}', $this->contract->sidewall, $content);
            $content = str_replace('{{DRIVEWAY}}', $this->contract->driveway, $content);
            $content = str_replace('{{SHINGLE}}', $this->contract->shingle, $content);
            $content = str_replace('{{COLOR}}', $this->contract->color, $content);
            $content = str_replace('{{DRIP_EDGE}}', $this->contract->dripedge, $content);
            $content = str_replace('{{MATERIAL_DROP}}', $this->contract->material_drop, $content);
            $content = str_replace('{{VENTILATION}}', $this->contract->ventilation, $content);

            $content = str_replace('{{DESCRIPTION}}', $this->contract->description, $content); 

            /* Replace Agreement Variable variables */
            $content = str_replace('{{CUSTOMER_ADDRESS_ONLY}}', $custAddOnly, $content);
            $content = str_replace('{{CUSTOMER_CITY_STATE_ZIP}}', $custAddCSZ, $content);
            $content = str_replace('{{CUSTOMER_EMAIL}}', $custEmail, $content);
            $content = str_replace('{{INSURANCE_COMPANY_PHONE}}', $this->contract->phonenumber, $content);
            $aggreDate = ($this->contract->dateadded)?date('d M y, h:i A', strtotime($this->contract->dateadded)):'-';
            $content = str_replace('{{AGREEMENT_DATE}}', $aggreDate, $content);
            $content = str_replace('{{CUSTOMER_PHONE}}', (isset($this->contract->leadDetail))?$this->contract->leadDetail->phonenumber:'-', $content);
            $ic_value = $dol_value = $cn_value = $an_value = $ap_value = $pn_value = '-';
            if(isset($this->contract->leadDetail)){
                $ic_value = get_custom_field_value($this->contract->leadDetail->id, 1, 'leads');              
                $ic_value = ($ic_value?$ic_value:'-');
                
                $dol_value = get_custom_field_value($this->contract->leadDetail->id, 3, 'leads');     
                $dol_value = ($dol_value?$dol_value:'-');
                
                /*$cn_value = get_custom_field_value($this->contract->leadDetail->id, 5, 'leads');
                $cn_value = ($cn_value?$cn_value:'-'); */

                $an_value = get_custom_field_value($this->contract->leadDetail->id, 7, 'leads');
                $an_value = ($an_value?$an_value:'-');

                $ap_value = get_custom_field_value($this->contract->leadDetail->id, 8, 'leads');
                $ap_value = ($ap_value?$ap_value:'-');

                /*$pn_value = get_custom_field_value($this->contract->leadDetail->id, 29, 'leads');
                $pn_value = ($pn_value?$pn_value:'-');*/
            }
            $cn_value = ($this->contract->claim_number?$this->contract->claim_number:'-');
            $pn_value = ($this->contract->policy_number?$this->contract->policy_number:'-');
            $content = str_replace('{{INSURANCE_COMPANY}}', $ic_value, $content);
            $content = str_replace('{{DATE_OF_LOSS}}', $dol_value, $content);
            $content = str_replace('{{CLAIM_NUMBER}}', $cn_value, $content);
            $content = str_replace('{{ADJUSTER_NAME}}', $an_value, $content);
            $content = str_replace('{{ADJUSTER_PHONE}}', $ap_value, $content);

            //$pn_value = ($this->contract->policy_number != '')?$this->contract->policy_number:'-';
            $content = str_replace('{{POLICY_NUMBER}}', $pn_value, $content);

            $adjd_value = ($this->contract->adj_appoint_date != '')?$this->contract->adj_appoint_date:'-';
            $content = str_replace('{{ADJ_DATE} }', $adjd_value.' ', $content);

            $adjt_value = ($this->contract->adj_appoint_time != '')?$this->contract->adj_appoint_time:'-';
            $content = str_replace('{{ADJ_TIME}}', $adjt_value, $content);

            $racv_value = ($this->contract->acv_rcv_aggre != '')?strtoupper($this->contract->acv_rcv_aggre):'-';
            $content = str_replace('RCV / ACV', ' '.$racv_value, $content);      
        }
        //$content = str_replace('{{CONTRACTOR__SIGNATURE}}', '<img src="{{CONTRACTOR_SIGNATURE}}">', $content);
        //$content = str_replace('{{CUSTOMER__SIGNATURE}}', '<img src="{{CUSTOMER_SIGNATURE}}">', $content);
        // Remove any inline definitions for font family as it's causing issue with
        // the PDF font, in this case, only the PDF font will be used to generate the PDF document
        // the inline defitions will be used for HTML view
        $content = preg_replace('/font-family.+?;/m', '', $content);

        return $content;
    }

    protected function load_language($client_id)
    {
        load_pdf_language(get_client_default_language($client_id));

        return $this;
    }

    protected function get_file_path()
    {
        return hooks()->apply_filters($this->type() . '_pdf_build_path', $this->file_path());
    }

    protected function build()
    {
        _bulk_pdf_export_maybe_tag($this->tag, $this);

        if ($path = $this->get_file_path()) {

            // Backwards compatible
            $pdf = $this;
            $CI  = $this->ci;

            // The view vars, also backwards compatible
            extract($this->view_vars);
            include($path);
        }

        if (ob_get_length() > 0 && ENVIRONMENT == 'production') {
            ob_end_clean();
        }

        return $this;
    }

    private function set_default_view_vars()
    {
        $this->set_view_vars([
            'pdf_custom_fields' => $this->custom_fields(),
            'swap'              => $this->swap,
            'font_size'         => $this->get_font_size(),
            'font_name'         => $this->get_font_name(),
        ]);
    }

    public function with_number_to_word($client_id)
    {
        $this->ci->load->library('app_number_to_word', [ 'clientid' => $client_id ], 'numberword');

        return $this;
    }

    /**
    * Unset all class variables except the following critical variables.
    *
    * @param $destroyall (boolean) if true destroys all class variables, otherwise preserves critical variables.
    * @param $preserve_objcopy (boolean) if true preserves the objcopy variable
    *
    * @since 4.5.016 (2009-02-24)
    */
    public function _destroy($destroyall = false, $preserve_objcopy = false)
    {
        // restore internal encoding
        if (isset($this->internal_encoding) and !empty($this->internal_encoding)) {
            mb_internal_encoding($this->internal_encoding);
        }

        if (isset(self::$cleaned_ids[$this->file_id])) {
            $destroyall = false;
        }

        if ($destroyall and !$preserve_objcopy) {
            self::$cleaned_ids[$this->file_id] = true;
            // remove all temporary files
            if ($handle = @opendir(K_PATH_CACHE)) {
                while (false !== ($file_name = readdir($handle))) {
                    $fullPath = K_PATH_CACHE . $file_name;
                    if (strpos($file_name, '__tcpdf_' . $this->file_id . '_') === 0 && file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }

                closedir($handle);
            }

            if (isset($this->imagekeys)) {
                foreach ($this->imagekeys as $file) {
                    if (strpos($file, K_PATH_CACHE) === 0 && file_exists($file)) {
                        @unlink($file);
                    }
                }
            }
        }

        $preserve = [
            'file_id',
            'internal_encoding',
            'state',
            'bufferlen',
            'buffer',
            'cached_files',
            'imagekeys',
            'sign',
            'signature_data',
            'signature_max_length',
            'byterange_string',
            'tsa_timestamp',
            'tsa_data',
        ];

        foreach (array_keys(get_object_vars($this)) as $val) {
            if ($destroyall or !in_array($val, $preserve)) {
                if ((!$preserve_objcopy or ($val != 'objcopy')) and ($val != 'file_id') and isset($this->$val)) {
                    unset($this->$val);
                }
            }
        }
    }
}

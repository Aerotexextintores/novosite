<?php
/**
 * O2TI Soluções Web Ltda.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the New BSD License.
 * It is also available through the world-wide-web at this URL:
 * http://www.o2ti.com/new-bsd-license/
 *
 * @category   O2TI
 * @package    O2TI_Sisfrete
 * @copyright  Copyright (c) 2011 O2TI Soluções Web Ltda. (http://www.o2ti.com)
 * @author     O2TI Soluções Web Ltda. <contato@o2ti.com>
 * @license    http://www.o2ti.com/new-bsd-license/ New BSD License
 */

/**
 * O2TI_Sisfrete_Model_Carrier_SisfreteMethod
 *
 * @category   O2TI
 * @package    O2TI_Sisfrete
 * @author     O2TI Soluções Web Ltda. <contato@o2ti.com>
 */

class O2TI_Sisfrete_Model_Carrier_SisfreteMethod
extends Mage_Shipping_Model_Carrier_Abstract
implements Mage_Shipping_Model_Carrier_Interface
{

	/**
	 * _code property
	 *
	 * @var string
	 */
	protected $_code                    = 'O2TI_Sisfrete';

	/**
	 * _result property
	 *
	 * @var Mage_Shipping_Model_Rate_Result / Mage_Shipping_Model_Tracking_Result
	 */
	protected $_result                  = null;

	/**
	 * ZIP code vars
	 */
	protected $_fromZip                 = null;
	protected $_toZip                   = null;

	/**
	 * Value and Weight
	 */
	protected $_packageValue            = null;
	protected $_packageWeight           = null;
	protected $_volumeWeight            = null;
	protected $_freeMethodWeight        = null;

	/**
	 * Post methods
	 */
	protected $_postMethods             = null;
	protected $_postMethodsFixed        = null;
	protected $_postMethodsExplode      = null;

	/**
	 * Free method request
	 */
	protected $_freeMethodRequest       = false;
	protected $_freeMethodRequestResult = null;

	/**
	 * Collect Rates
	 *
	 * @param Mage_Shipping_Model_Rate_Request $request
	 * @return Mage_Shipping_Model_Rate_Result
	 */
	public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
		// Do initial check
		if ($this->_inicialCheck($request) === false) {
			return false;
		}

		// Check package value
		if ($this->_packageValue < $this->getConfigData('min_order_value') || $this->_packageValue > $this->getConfigData('max_order_value')) {
			// Value limits
			$this->_throwError('valueerror', 'Value limits', __LINE__);
			return $this->_result;
		}

		// Check ZIP Code
		if (!preg_match("/^([0-9]{8})$/", $this->_toZip)) {
			// Invalid Zip Code
			$this->_throwError('zipcodeerror', 'Invalid Zip Code', __LINE__);
			return $this->_result;
		}

		// Fix weight
		$weightCompare = $this->getConfigData('maxweight');
		if ($this->getConfigData('weight_type') == 'gr') {
			$this->_packageWeight = number_format($this->_packageWeight/1000, 2, '.', '');
			$weightCompare = number_format($weightCompare/1000, 2, '.', '');
		}

		// Check weght
		if ($this->_packageWeight > $weightCompare) {
			//Weight exceeded limit
			$this->_throwError('maxweighterror', 'Weight exceeded limit', __LINE__);
			return $this->_result;
		}

		// Check weight zero
		if ($this->_packageWeight <= 0) {
			// Weight zero
			$this->_throwError('weightzeroerror', 'Weight zero', __LINE__);
			return $this->_result;
		}

		// Generate Volume Weight
		if ($this->_generateVolumeWeight() === false) {
			// Dimension error
			$this->_throwError('dimensionerror', 'Dimension error', __LINE__);
			return $this->_result;
		}

		// Get post methods
		$this->_postMethods = $this->getConfigData('postmethods');
		$this->_postMethodsFixed = $this->_postMethods;
		$this->_postMethodsExplode = explode(",", $this->getConfigData('postmethods'));

		// Get quotes
		if ($this->_getQuotes()->getError()) {
			return $this->_result;
		}

		// Use descont codes
		$this->_updateFreeMethodQuote($request);

		// Return rates / errors
		return $this->_result;

	}

	/**
	 * Get shipping quote
	 *
	 * @return object
	 */

	protected function _getQuotes() {

		$dieErrors = explode(",", $this->getConfigData('die_errors'));

		// Call Sisfrete
		$SisfreteReturn = $this->_getSisfreteReturn();

		if ($SisfreteReturn !== false) {

			// Check if exist return from Sisfrete
			$existReturn = false;
			

			foreach ($SisfreteReturn as $servicos) {


				// Get Sisfrete error
				$errorId = $this->_cleanSisfreteError((string)$servicos->erro);

				if ($errorId != 0) {
					// Error, throw error message
					if (in_array($errorId, $dieErrors)) {
						$this->_throwError('Sisfreteerror', 'Sisfrete Error: ' . (string)$servicos->erro . ' [Cod. ' . $errorId . '] [Serv. ' . (string)$servicos->Codigo . ']' , __LINE__, (string)$servicos->erro . ' (Cod. ' . $errorId . ')');
						return $this->_result;
					}else {
						continue;
					}
				}

				$shippingPrice = floatval(str_replace(",", ".", (string)$servicos->valor));
				$shippingDelivery = (int)$servicos->prazo_max;


				$nome_da_transp = (string)$servicos->transportadora. " - ". (string)$servicos->servico;

				$transportadora ="-".(string)$servicos->base.'-'.(string)$servicos->servico;

				/*$super = rand(19,2); travado para avaliação do que está havendo com a tag já testei e é mesmo um string (string)$servicos->cod_nf;*/



				if ($shippingPrice <= -99) {
					continue;
				}
				if ((string)$servicos->base != ""){

				// Apend shipping
				$this->_apendShippingReturn($nome_da_transp, (string)$transportadora, $shippingPrice, $shippingDelivery);
				}
				else {
				$this->_throwError('urlerror', 'URL Error - ' . "bios", __LINE__);
				}
				$existReturn = true;
			}

			// All services are ignored
			if ($existReturn === false) {
				$this->_throwError('urlerror', 'URL Error, all services return with error', __LINE__);
				return $this->_result;
			}

		}else {
			// Error on HTTP Sisfrete
			return $this->_result;
		}

		// Success
		if ($this->_freeMethodRequest === true) {
			return $this->_freeMethodRequestResult;
		}else {
			return $this->_result;
		}
	}


	/**
	 * Make initial checks and iniciate module variables
	 *
	 * @param Mage_Shipping_Model_Rate_Request $request
	 * @return boolean
	 */
	protected function _inicialCheck(Mage_Shipping_Model_Rate_Request $request) {

		if (!$this->getConfigFlag('active')) {
			//Disabled
			Mage::log('O2TI_Sisfrete: Disabled');
			return false;
		}


		$origCountry = Mage::getStoreConfig('shipping/origin/country_id', $this->getStore());
		$destCountry = $request->getDestCountryId();
		if ($origCountry != "BR" || $destCountry != "BR") {
			//Out of delivery area
			Mage::log('O2TI_Sisfrete: Out of delivery area');
			return false;
		}

		// ZIP Code
		$this->_fromZip = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore());
		$this->_toZip = $request->getDestPostcode();

		//Fix Zip Code
		$this->_fromZip = str_replace(array('-', '.'), '', trim($this->_fromZip));
		$this->_toZip = str_replace(array('-', '.'), '', trim($this->_toZip));

		if (!preg_match("/^([0-9]{8})$/", $this->_fromZip)) {
			//From zip code error
			Mage::log('O2TI_Sisfrete: From ZIP Code Error');
			return false;
		}

		// Result model
		$this->_result = Mage::getModel('shipping/rate_result');

		// Value
		$this->_packageValue = $request->getBaseCurrency()->convert(
			$request->getPackageValue(),
			$request->getPackageCurrency()
		);

		// Weight
		$this->_packageWeight = number_format($request->getPackageWeight(), 2, '.', '');

		// Free method weight
		$this->_freeMethodWeight = number_format($request->getFreeMethodWeight(), 2, '.', '');

	}

	/**
	 * Get Sisfrete return
	 *
	 * @return bool
	 */
	protected function _getSisfreteReturn() {
		$quant = "";
		$items ="";
		$produtos = '';
		$items = Mage::getModel('checkout/cart')->getQuote()->getAllVisibleItems();
		$coeficinete = count($items);
		$controlee = 0;
		foreach ($items as $item) {
			$preco = 0;
			$itemLargurab = 0;
			$itemAlturab = 0;
			$weightb = 0;
			$itemComprimentob = 0;
			$pesoCubicoTotal = 0;
			$preco = 0;			
			$_product = $item->getProduct();
			$weightb = $_product->getWeight();
			$skub = 1;
			  if($_product->getData('volume_altura') == '' || (int)$_product->getData('volume_altura') == 0)
                $itemAlturab = $this->getConfigData('altura_padrao');
            else
                $itemAlturab = $_product->getData('volume_altura');

            if($_product->getData('volume_largura') == '' || (int)$_product->getData('volume_largura') == 0)
                $itemLargurab = $this->getConfigData('largura_padrao');
            else
                $itemLargurab = $_product->getData('volume_largura');

            if($_product->getData('volume_comprimento') == '' || (int)$_product->getData('volume_comprimento') == 0)
                $itemComprimentob = $this->getConfigData('comprimento_padrao');
            else
                $itemComprimentob = $_product->getData('volume_comprimento');

			$preco = $_product->getFinalPrice();
			if($coeficinete > 1):
				$somaprod = "/";
				$coeficinete = $coeficinete -1;
			else:
				$somaprod = ";";
			endif;
			$quququ = $item->getQty();
			$pesoCubicoTotal = ($itemAlturab*$itemLargurab*$itemComprimentob);
			$produtos .= ($itemComprimentob/100).";".($itemLargurab/100).";".($itemAlturab/100).";".$pesoCubicoTotal.";".$quququ.";".$weightb.";".$skub.";".$preco."".$somaprod;

		}
		$filename = "http://frete.sisfrete.com.br/cotacao/mod_prod_calc01.php";
		
		try {
			$client = new Zend_Http_Client($filename);
			$client->setConfig(array(
					'timeout' => $this->getConfigData('ws_timeout')
				));
			$client->setParameterGet('token', $this->getConfigData('cod_admin'));
			$client->setParameterGet('envio', '1');
			$client->setParameterGet('cep_destino', $this->_toZip);
			$client->setParameterGet('num_ped', '13');
			$client->setParameterGet('prods', $produtos);
			$content = $client->request()->getBody();
			if ($content == "") {
				throw new Exception("No XML returned [" . __LINE__ . "]");
			}

			libxml_use_internal_errors(true);
			$sxe = simplexml_load_string($content);
			if (!$sxe) {
				throw new Exception("Bad XML [" . __LINE__ . "]");
			}

			// Load XML
			$xml = new SimpleXMLElement($content);

			if (count($xml->resultado) <= 0) {
				throw new Exception("No tag resultado in Sisfrete XML [" . __LINE__ . "]");
			}


			return $xml->resultado;

		} catch (Exception $e) {
			//URL Error
			$this->_throwError('urlerror', 'URL Error - ' . $e->getMessage(), __LINE__);
			return false;
		};
	}

	protected function _apendShippingReturn($nome_da_transp, $shipping_method, $shippingPrice = 0, $SisfreteDelivery = 0) {

		$method = Mage::getModel('shipping/rate_result_method');
		$method->setCarrier($this->_code);
		$method->setCarrierTitle($this->getConfigData('title'));
		$method->setMethod($shipping_method);

		$shippingCost = $shippingPrice;
		$shippingPrice = $shippingPrice + $this->getConfigData('handling_fee');

		$shipping_data = explode(',', $this->getConfigData('serv_' . $shipping_method));

		if ($shipping_method == $this->getConfigData('acobrar_code')) {
			$shipping_data[0] = $shipping_data[0] . ' ( R$' . number_format($shippingPrice, 2, ',', '.') . ' )';
			$shippingPrice = 0;
		}


		
		if ($this->getConfigFlag('prazo_entrega')) {
			// Delivery days from WS
			if ($SisfreteDelivery  > 0) {
				$method->setMethodTitle($nome_da_transp.sprintf($this->getConfigData('msgprazo'), $shipping_data[0], (int)($SisfreteDelivery)));
			}else {
				$method->setMethodTitle($nome_da_transp.sprintf($this->getConfigData('msgprazo'), $shipping_data[0], (int)($shipping_data[1])));
			}
		}else {
			$method->setMethodTitle($shipping_data[0]);
		}
		$method->setPrice($shippingPrice);

		$method->setCost($shippingCost);

		if ($this->_freeMethodRequest === true) {
			$this->_freeMethodRequestResult->append($method);
		}else {
			$this->_result->append($method);
		}
	}

	/**
	 * Throw error
	 *
	 * @param $message string
	 * @param $log     string
	 * @param $line    int
	 * @param $custom  string
	 * @return void
	 */
	protected function _throwError($message, $log = null, $line = 'NO LINE', $custom = null) {

		$this->_result = null;
		$this->_result = Mage::getModel('shipping/rate_result');

		// Get error model
		$error = Mage::getModel('shipping/rate_result_error');
		$error->setCarrier($this->_code);
		$error->setCarrierTitle($this->getConfigData('title'));

		if (is_null($custom) || $this->getConfigData($message) == '') {
			//Log error
			Mage::log($this->_code . ' [' . $line . ']: ' . $log);
			$error->setErrorMessage($this->getConfigData($message));
		}else {
			//Log error
			Mage::log($this->_code . ' [' . $line . ']: ' . $log);
			$error->setErrorMessage(sprintf($this->getConfigData($message), $custom));
		}

		// Apend error
		$this->_result->append($error);
	}

	/**
	 * Generate Volume weight
	 *
	 * @return bool
	 */
	protected function _generateVolumeWeight() {
		//Create volume weight
		$pesoCubicoTotal = 0;

		// Get all visible itens from quote
		$items = Mage::getModel('checkout/cart')->getQuote()->getAllVisibleItems();

		foreach ($items as $item) {

			$itemAltura= 0;
			$itemLargura = 0;
			$itemComprimento = 0;

			$_product = $item->getProduct();

			if ($_product->getData('volume_altura') == '' || (int)$_product->getData('volume_altura') == 0)
				$itemAltura = $this->getConfigData('altura_padrao');
			else
				$itemAltura = $_product->getData('volume_altura');

			if ($_product->getData('volume_largura') == '' || (int)$_product->getData('volume_largura') == 0)
				$itemLargura = $this->getConfigData('largura_padrao');
			else
				$itemLargura = $_product->getData('volume_largura');

			if ($_product->getData('volume_comprimento') == '' || (int)$_product->getData('volume_comprimento') == 0)
				$itemComprimento = $this->getConfigData('comprimento_padrao');
			else
				$itemComprimento = $_product->getData('volume_comprimento');

			if ($this->getConfigFlag('check_dimensions')) {
				if (
					$itemAltura > $this->getConfigData('volume_validation/altura_max')
					|| $itemAltura < $this->getConfigData('volume_validation/altura_min')
					|| $itemLargura > $this->getConfigData('volume_validation/largura_max')
					|| $itemLargura < $this->getConfigData('volume_validation/largura_min')
					|| $itemComprimento > $this->getConfigData('volume_validation/comprimento_max')
					|| $itemComprimento < $this->getConfigData('volume_validation/comprimento_min')
					|| ($itemAltura+$itemLargura+$itemComprimento) > $this->getConfigData('volume_validation/sum_max')
				) {
					return false;
				}
			}

			$pesoCubicoTotal += (($itemAltura*$itemLargura*$itemComprimento)*$item->getQty())/$this->getConfigData('coeficiente_volume');
		}

		$this->_volumeWeight = number_format($pesoCubicoTotal, 2, '.', '');

		return true;
	}

	/**
	 * Generate free shipping for a product
	 *
	 * @param string $freeMethod
	 * @return void
	 */
	protected function _setFreeMethodRequest($freeMethod) {
		// Set request as free method request
		$this->_freeMethodRequest = true;
		$this->_freeMethodRequestResult = Mage::getModel('shipping/rate_result');

		$this->_postMethods = $freeMethod;
		$this->_postMethodsExplode = array($freeMethod);

		// Tranform free shipping weight
		if ($this->getConfigData('weight_type') == 'gr') {
			$this->_freeMethodWeight = number_format($this->_freeMethodWeight/1000, 2, '.', '');
		}

		$this->_packageWeight = $this->_freeMethodWeight;
		$this->_pacWeight = $this->_freeMethodWeight;
	}

	/**
	 * Clean Sisfrete error code, usualy with "-" before the code
	 *
	 * @param string $error
	 * @return int
	 */
	protected function _cleanSisfreteError($error) {
		$error = str_replace('-', '', $error);
		$error = (int)$error;
		return $error;
	}


	/**
	 * Check if current carrier offer support to tracking
	 *
	 * @return boolean true
	 */
	public function isTrackingAvailable() {
		return true;
	}

	/**
	 * Get Tracking Info
	 *
	 * @param mixed $tracking
	 * @return mixed
	 */
	public function getTrackingInfo($tracking) {
		$result = $this->getTracking($tracking);
		if ($result instanceof Mage_Shipping_Model_Tracking_Result) {
			if ($trackings = $result->getAllTrackings()) {
				return $trackings[0];
			}
		} elseif (is_string($result) && !empty($result)) {
			return $result;
		}
		return false;
	}

	/**
	 * Get Tracking
	 *
	 * @param array $trackings
	 * @return Mage_Shipping_Model_Tracking_Result
	 */
	public function getTracking($trackings) {
		$this->_result = Mage::getModel('shipping/tracking_result');
		foreach ((array) $trackings as $code) {
			$this->_getTracking($code);
		}
		return $this->_result;
	}

	/**
	 * Protected Get Tracking, opens the request to Sisfrete
	 *
	 * @param string $code
	 * @return boolean
	 */
	protected function _getTracking($code) {
		$error = Mage::getModel('shipping/tracking_result_error');
		$error->setTracking($code);
		$error->setCarrier($this->_code);
		$error->setCarrierTitle($this->getConfigData('title'));
		$error->setErrorMessage($this->getConfigData('urlerror'));

		$url = 'http://websro.Sisfrete.com.br/sro_bin/txect01$.QueryList';
		$url .= '?P_LINGUA=001&P_TIPO=001&P_COD_UNI=' . $code;
		try {
			$client = new Zend_Http_Client();
			$client->setUri($url);
			$content = $client->request();
			$body = $content->getBody();
		} catch (Exception $e) {
			$this->_result->append($error);
			return false;
		}

		if (!preg_match('#<table ([^>]+)>(.*?)</table>#is', $body, $matches)) {
			$this->_result->append($error);
			return false;
		}
		$table = $matches[2];

		if (!preg_match_all('/<tr>(.*)<\/tr>/i', $table, $columns, PREG_SET_ORDER)) {
			$this->_result->append($error);
			return false;
		}

		$progress = array();
		for ($i = 0; $i < count($columns); $i++) {
			$column = $columns[$i][1];

			$description = '';
			$found = false;
			if (preg_match('/<td rowspan="?2"?/i', $column) && preg_match('/<td rowspan="?2"?>(.*)<\/td><td>(.*)<\/td><td><font color="[A-Z0-9]{6}">(.*)<\/font><\/td>/i', $column, $matches)) {
				if (preg_match('/<td colspan="?2"?>(.*)<\/td>/i', $columns[$i+1][1], $matchesDescription)) {
					$description = str_replace('  ', '', $matchesDescription[1]);
				}

				$found = true;
			} elseif (preg_match('/<td rowspan="?1"?>(.*)<\/td><td>(.*)<\/td><td><font color="[A-Z0-9]{6}">(.*)<\/font><\/td>/i', $column, $matches)) {
				$found = true;
			}

			if ($found) {
				$datetime = explode(' ', $matches[1]);
				$locale = new Zend_Locale('pt_BR');
				$date='';
				$date = new Zend_Date($datetime[0], 'dd/MM/YYYY', $locale);

				$track = array(
					'deliverydate' => $date->toString('YYYY-MM-dd'),
					'deliverytime' => $datetime[1] . ':00',
					'deliverylocation' => htmlentities($matches[2]),
					'status' => htmlentities($matches[3]),
					'activity' => htmlentities($matches[3])
				);

				if ($description !== '') {
					$track['activity'] = $matches[3] . ' - ' . htmlentities($description);
				}

				$progress[] = $track;
			}
		}

		if (!empty($progress)) {
			$track = $progress[0];
			$track['progressdetail'] = $progress;

			$tracking = Mage::getModel('shipping/tracking_result_status');
			$tracking->setTracking($code);
			$tracking->setCarrier('Sisfrete');
			$tracking->setCarrierTitle($this->getConfigData('title'));
			$tracking->addData($track);

			$this->_result->append($tracking);
			return true;
		} else {
			$this->_result->append($error);
			return false;
		}
	}

	/**
	 * Returns the allowed carrier methods
	 *
	 * @return array
	 */
	public function getAllowedMethods() {
		return array($this->_code => $this->getConfigData('title'));
	}

	/**
	 * Define ZIP Code as required
	 *
	 * @return boolean
	 */
	public function isZipCodeRequired($countryId = null) {
		return false;
	}
}

<?php

class O2TI_Sisfrete_Model_Observer
{
	public function createorder_sisfrete($observer)
	{
		$event = $observer->getEvent();
		$Id = $observer->getEvent()->getOrder()->getId();
		$incrementid = $observer->getEvent()->getOrder()->getIncrementId();
		$base = $observer->getEvent()->getOrder()->getShippingMethod();
		$base = explode("-", $base);
		$base = trim($base[1]);
		$cod_nf = $observer->getEvent()->getOrder()->getShippingDescription();
		$cod_nf = explode("-", $cod_nf);
		$cod_nf = trim($cod_nf[3]);
		$preco_nota = $observer->getEvent()->getOrder()->getGrandTotal();
		$preco_nota = number_format($preco_nota, 2, '.', '.');
		$html = $this->simple_curl('http://frete.sisfrete.com.br/cotacao/grava_dados_sisfrete01.php', array(
						'token'=>'04966EAB3EEB41079B82AD1A443C1B34',
						'cod_calculo'=>$cod_nf,
						'base'=>$base,
						'valor_cobrado_nf'=>$preco_nota,
					));

		Mage::log("Resposta ".$html);
		return $this;
	}

	public function simple_curl($url, $post=array(), $get=array())
	{
		$url = explode('?', $url, 2);
			if (count($url)===2)
			{
				$temp_get = array();
				parse_str($url[1], $temp_get);
				$get = array_merge($get, $temp_get);
			}
		$ch = curl_init($url[0]."?".http_build_query($get));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec($ch);
	}
}

<?php
	require_once('autoload.php');
	require_once('FPDF/fpdf.php');

	class Admin extends User{

		public static function getQrCodeFromSet($id_set,$width,$height){ // return url
			$query= "SELECT * FROM LM_set, LM_materiel WHERE LM_set.id_set = LM_materiel.id_set AND LM_set.id_set = $id_set";
			$stmt = myPDO::getSingletonPDO()->query($query);

			$chaine_qr = '';
			while($ligne = $stmt->fetch()){
				if($ligne['reference_campus'] != NULL){
					$chaine_qr.=$ligne['reference_campus'].',';
				}
			}
			$chaine_qr = preg_replace('/,$/','', $chaine_qr);
			return "http://chart.googleapis.com/chart?cht=qr&chs=".$width.'x'.$height.'&chl='.urlencode(utf8_encode($chaine_qr)).'&choe=UTF-8';
		}

		public static function getPdfFromSet($id_set,$width_qr,$height_qr){
			$stmt = myPDO::getSingletonPDO()->query("SELECT description,id_set FROM LM_set WHERE id_set = $id_set");
			if($ligne = $stmt->fetch()){
				$description = utf8_decode($ligne['description']);
				$pdf = new FPDF('P','mm','A4');
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',16);
				$pdf->MultiCell(0,10,'Set id : '.$ligne['id_set'],0,'C');
				$pdf->MultiCell(0,10,$description,0,'C');
				$url = self::getQrCodeFromSet($id_set,$width_qr,$height_qr);
				$pdf->Image($url,60,100,90,0,'PNG');
				$pdf->output();
			}
		}
	}

	//var_dump(Admin::genereQrCodeFromSet(1,500,500));
	//Admin::getPdfFromSet(1,500,500);

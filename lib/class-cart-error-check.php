<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Error_Check {

  function deliver_check( $form,$error=null ) {
  //_POST form data receive
      $flag=0;
      foreach ( $_POST as $key=>$value ){
        if( empty( $form[ $key ] ) ) { continue; }
        if( empty( $value ) ) {
          $error[ $key ] = "error"; //Form Data empty = ErrorMessage send
        }
      }
    return $error;
   }
   
  function postdata_check( $form=null,$error=null ) {
    if( isset( $_POST ) ){
      //if( ! empty( $_POST['_indispen'] ) ) { // Option Input form data hidden _indispan[] 
       // foreach ( $_POST['_indispen'] as $key => $value ){ $form[ $key ]	=	$value; }
       //}
      //Form POST DATA receive
      foreach ( $_POST as $key=>$value ){  
        $_POST[ $key ]	=	strip_tags( $value );//POST Data conver
        #$_POST[$key]= mb_convert_kana($value,"K");
        if( empty( $form[ $key ] ) ) { continue; }
        if( empty( $value ) ) {
          $error[ $key ] = "error"; //Form Data empty = ErrorMessage send
        }
      }
    }
    $error	=	$this->mailaddress_check($form,$error);
    return $error;//return to error message
   }

   function mailaddress_check( $form,$error) {
	   if( isset( $_POST['customer_mailaddress1'] ) ) {
		   	$customer_mailaddress1	=	sanitize_text_field( $_POST['customer_mailaddress1'] );
    		$customer_mailaddress1	=	mb_convert_kana( $customer_mailaddress1,"a" ) ;
			$emailcheck						=	$this->mail_check1( $customer_mailaddress1 );
			if( empty( $emailcheck ) ) {
	  			$error['customer_mailaddress1']	=	"wrong";//Form Data is wrong = ErrorMessage
	  		}
		}
		if( isset( $_POST['customer_mailaddress2'] ) ) {
			$customer_mailaddress2	=	sanitize_text_field( $_POST['customer_mailaddress2'] );
    		$customer_mailaddress2	=	mb_convert_kana( $customer_mailaddress2,"a" ) ;
			$emailcheck				=	$this->mail_check1( $customer_mailaddress2 ); 
			if( empty( $emailcheck ) ) {
				$error['customer_mailaddress2']	=	"wrong";//Form Data is "wrong" = ErrorMessage
      		}
    	}
		if( isset( $_POST['customer_mailaddress1'],$_POST['customer_mailaddress2'] ) ) {
			$customer_mailaddress1	=	sanitize_text_field( $_POST['customer_mailaddress1'] );
			$customer_mailaddress2	=	sanitize_text_field( $_POST['customer_mailaddress2'] );
	    	$emailcheck = $this->check2( $customer_mailaddress1,$customer_mailaddress2 ); 
			if(empty($emailcheck)){
        		$error['customer_mailaddress2'] = "different";//Form Data is "different" = ErrorMessage
      		}
		}
		return $error;
	}

//_POST check for Email address
  function mail_check1($email=null){ 
    if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i',$email)){
      return true;
    } else {
      return false;
    }
  }

//retry POST email address check
  function check2($num1=null,$num2=null){
    if($num1===$num2){
      return true;
    } else {
      return false;
    }
  }

}

?>
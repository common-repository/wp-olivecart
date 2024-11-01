function OliveCart_Mail_reset(action,message){
		if(action == 's_edit'){
			if(window.confirm(message)){
			  document.getElementById('action').value = 's_mail_reset';
			  document.Form.submit();
  			}
		}
		if(action == 'p_edit'){
			if(window.confirm(message)){
			  document.getElementById('action').value = 'p_mail_reset';
			  document.Form.submit();
  			}
		}
		if(action == 'edit'){	
			if(window.confirm(message)){
				document.getElementById('action').value = 'mail_reset';
				document.Form.submit();
			}
		}

}

 

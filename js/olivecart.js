/*
 * Shopping Cart System WP Olive-Cart.
 */

function OliveCart_Step2(){
		location.href = OliveCartPermalinkUrl;
}
function OliveCart_postIn(ButtonId,Number,Nonce){
	var option1 ='';
	var Count;
	var option_id1 = 'option1_'+ButtonId;
	if(document.getElementById(option_id1)){
		var option1 = document.getElementById(option_id1).value;
	}
	var count_id = 'count_'+ButtonId;
	if(document.getElementById(count_id)){ 
		var Count = document.getElementById(count_id).value;
	}
	else{
		Count='1';
	}
	if(document.getElementById("maincart")){
		var frm = new OliveCart_postSubmit();
		frm.add('number',Number);
		frm.add('count',Count);
		frm.add('olivecart_nonce',Nonce);
		if(document.getElementById(option_id1)){ frm.add('option',option1); }
		frm.submit('', '_self');
	}
	else{
		location.href = "./?wp_olivecart=shoppingcart&step=2&count="+Count+"&number="+Number+"&option="+option1+'&olivecart_nonce='+Nonce;
	}
}
function OliveCart_postSubmit() {
    this.frmObject = document.createElement("form");
    this.frmObject.method = "get";
    
    this.add = function(elementname, elementvalue) {
       var input = document.createElement("input");
	     input.type = "hidden";
	     input.name = elementname;
	     input.value = elementvalue;
       this.frmObject.appendChild(input);
       this.frmObject.method = "post";
    };
    
    this.submit = function(url, targetFrame) {
      try {
        if (targetFrame) {
          this.frmObject.target = targetFrame;
        }
      } catch (e) { }
      
      try {
      //  if (url) {
         this.frmObject.action = url;
          document.body.appendChild(this.frmObject);
          this.frmObject.submit();
          return true;
       // } else { return false; }
      } catch (e) {
         return false;
      }
    };
}
function OliveCart_addSelOption( selObj, inValue, inText ){
   selObj.length++;
   selObj.options[ selObj.length - 1].value = inValue ;
   selObj.options[ selObj.length - 1].text  = inText;
 }
function OliveCart_createSelection( selObj, inTitle, aryValue, aryText ){
	selObj.length = 0;
	OliveCart_addSelOption( selObj, inTitle, inTitle);
	for( var i=0; i < aryValue.length; i++) {
		OliveCart_addSelOption ( selObj , aryValue[i], aryText[i]);
	}
}

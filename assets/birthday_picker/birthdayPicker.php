<style>
	.birthdayPicker select {
		border: 0 !important;  /*Removes border*/
		-webkit-appearance: none;  /*Removes default chrome and safari style*/
		-moz-appearance: none; /* Removes Default Firefox style*/
		 background-color: #FA2; background-image: -webkit-gradient(linear, left top, left bottom, from(#FA2), to(#ED8223));
 background-image: -webkit-linear-gradient(top, #FA2, #ED8223);
 background-image: -moz-linear-gradient(top, #FA2, #ED8223);
 background-image: -ms-linear-gradient(top, #FA2, #ED8223);
 background-image: -o-linear-gradient(top, #FA2, #ED8223);
 background-image: linear-gradient(to bottom, #FA2, #ED8223);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#FA2, endColorstr=#ED8223);
		width: 80px; /*Width of select dropdown to give space for arrow image*/
		text-indent: 0.01px; /* Removes default arrow from firefox*/
		text-overflow: "";  /*Removes default arrow from firefox*/ /*My custom style for fonts*/
		color: #FFF;
		border-radius: 15px;
		padding: 5px;
		box-shadow: inset 0 0 5px rgba(000,000,000, 0.5);
		margin-left:5px;
		text-align: center;
		font-size: 12px;
	}
	
	.birthdayPicker select:hover{
 background-color: #cf9f15; background-image: -webkit-gradient(linear, left top, left bottom, from(#cf9f15), to(#98740c));
 background-image: -webkit-linear-gradient(top, #cf9f15, #98740c);
 background-image: -moz-linear-gradient(top, #cf9f15, #98740c);
 background-image: -ms-linear-gradient(top, #cf9f15, #98740c);
 background-image: -o-linear-gradient(top, #cf9f15, #98740c);
 background-image: linear-gradient(to bottom, #cf9f15, #98740c);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#cf9f15, endColorstr=#98740c);
}
	
	.demo select.balck {
		background-color: #000;
	}
	.demo select.span1 {
		border-radius: 10px 0;
	}
</style>
<div id="birthdayPicker"></div>

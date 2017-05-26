<script type="text/javascript">
	function validateForm()
	{
		
		var letters = /^[A-Za-z]+$/;

		if(document.guide.f_name.value!="")
		{
			if(!(document.guide.f_name.value.match(letters)))
			{
				alert("Please Enter Valid First Name");
				return false;
			}
		}

		if(document.guide.l_name.value!="")
		{
			if(!(document.guide.l_name.value.match(letters)))
			{
				alert("Please Enter Valid Last Name");
				return false;
			}
		}

		if(document.guide.city.value!="")
		{
			if(!(document.guide.city.value.match(letters)))
			{
				alert("Please Enter Valid City");
				return false;
			}
		}

		if(document.guide.zipcode.value!="")
		{
			var number = /^[0-9]+$/;
			if(!(document.guide.zipcode.value.match(number)))
			{
				alert("Please Enter Valid Zipcode");
				return false;
			}
		}

		if(document.guide.contact.value!="")
		{
			var number = /^[0-9]+$/;
			if(!(document.guide.contact.value.match(number)))
			{ 
		    	alert("Please Enter Valid Telephone Number");  
				return false;  
			}
		}

		if(document.guide.college.value!="")
		{
			if(!(document.guide.college.value.match(letters)))
			{
				alert("Please Enter Valid College");
				return false;
			}
		}
		return true;
	}

</script>
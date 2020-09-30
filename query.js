function query(str)
		    {
			    $.ajax({
                        async:false,
                        data:{"query":str},
                        url:"db.php",
                        type:"GET",
                        success:function(data)
                        {
                            alert(data);
                        },
				    error:function(aa,bb,cc)
				    {
				    alert(bb);
			    }
                    });
		    }
        
        function resetMainTable()
        {
          str="DROP TABLE IF EXISTS mainTable CASCADE;
                CREATE TABLE mainTable(
                
                );"
        }

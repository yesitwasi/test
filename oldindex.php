<html>
	<head>
		<script src="jquery.js"></script>
		<script>
			class txt
			{
				
				constructor(t)
				{
					
					this.tags=t;
					this.url="https://gelbooru.com/index.php?page=post&s=list&tags="+this.tags+"&pid=0";
					loadPage(this.url);
					
					this.perPage=dt.getElementsByClassName("thumbnail-container").item(0).children.length;
					
					var pages=dt.getElementsByClassName("pagination").item(0).children;
					
					if(pages.length>1){
					var pagestrs=pages.item(pages.length-1).getAttribute("href").split("=");
					this.total=Number(pagestrs[pagestrs.length-1]);
					this.pageCache=new Array(this.total/this.perPage +1);
					var lastURL="https://gelbooru.com/index.php?page=post&s=list&tags="+this.tags+"&pid="+this.total;
						
						this.loadPageCache(0);
					loadPage(lastURL);
					this.total+=Number(dt.getElementsByClassName("thumbnail-container").item(0).children.length);
					
					
					this.loadPageCache(this.pageCache.length-1);
					
					
					}
					else
					{
						this.total=dt.getElementsByClassName("thumbnail-container").item(0).children.length;
						
						this.pageCache=new Array(1);
						this.loadPageChache(0);
					}
					
					
					this.showImage(43);
				}
				
				loadPageCache(page)
				{
					var container=dt.getElementsByClassName("thumbnail-container").item(0).children;
					this.pageCache[page]=new Array(container.length);
					
					for(var i=0;i<container.length;i++)
					{
						this.pageCache[page][i]=container.item(i).children.item(0).id.slice(1);
					}
				}
				showImage(num)
				{
					var page=Math.floor(num/this.perPage);
					var off=num%this.perPage;
					if(this.pageCache[page]==null)
					{
						loadPage("https://gelbooru.com/index.php?page=post&s=list&tags="+this.tags+"&pid="+(page*this.perPage));
						this.loadPageCache(page);
					}
					
					var id=this.pageCache[page][off];
					
					var  imgurl="https://gelbooru.com/index.php?page=post&s=view&id="+id;
					loadPage(imgurl);
					var isImage=dt.getElementById("right-col");
					if(isImage!=null){
						var proxy=["https://crossorigin.me/","https://cors-proxy.htmldriven.com/?url=","https://cors-anywhere.herokuapp.com/"];
						
						var realurl=proxy[2]+isImage.children.item(0).children.item(1).src;	
						
						var result = null;
     						    var URL = name;
      						   $.ajax({
         						   url: realurl,
      				   			   type: 'get',
         					 	  dataType: 'text/html',
         					   	async: false,
          						  crossDomain: 'true',
        						    success: function(data, status) {   
								    alert(data);
             					   		img.src='data:image/jpg;base64,' + data;
      						      } 
       						  });
						
						
						return imgTime;
					}
					else return 0;
					
					
				}
				
				
			};
			var vals;
			var list;
			var button;
			var audio;
			var perPage,total
			var img;
			var tts;
			var running;
			var imgTime;
			function addBox()
			{
				var el=document.createElement("li");
				list.appendChild(el);
				var box=document.createElement("input");
				box.setAttribute("type","text");
				el.appendChild(box);
			}
			function removeGUI()
			{
				var nodes=document.body.childNodes;
				nodes.forEach(function(n,i,l){document.body.removeChild(n)});
			}
			function initGUI()
			{
				list=document.createElement("ol");
				document.body.appendChild(list);	
				
				addBox();
				var box=document.createElement("input");
				box.setAttribute("type","button");
				box.setAttribute("onclick","initG()");
				list.childNodes.item(0).appendChild(box);
			}
			
			function reset()
			{
				removeGUI();
				initGUI();		
				
			}
			var dt;
			function loadPage(url)
			{
				
				var proxy=["https://crossorigin.me/","https://cors-proxy.htmldriven.com/?url=","https://cors-anywhere.herokuapp.com/"];
				var f=proxy[2]+url;
								
				 $.ajax({ url: f, success: function(data) {
	      	  	  
	  			var dom=new DOMParser();
	  			dt=dom.parseFromString(data,"text/html");
					 
					 },async: false});
				if(dt==null)alert("ERROR: "+f);
				
			}
			function initG()
			{
				removeGUI();
				var tags=list.childNodes.item(0).children.item(0).value;
				
				
				audio = document.createElement("AUDIO");
				var url1="https://freesound.org/data/previews/26/26777_128404-lq.mp3";
				audio.setAttribute("src",url1);
				document.body.appendChild(audio);
				img=document.createElement("img");

				document.body.appendChild(img);
				tts=new Array(0);
				tts.push(new txt(tags));
				running=true;
				imgTime=3000;
				setTimeout(changePic,3000);
				
				
			}
			
			function changePic()
			{
				if(!running)return;
				var id=Math.floor(Math.random()*tts[0].total);
				var tme=tts[0].showImage(id);
				setTimeout(changePic,tme);
			}
			
		</script>
	</head>

<body>
	aylmaoooo
   <script>
       reset();

      
       

    
  </script>

<body>
</html>

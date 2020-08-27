<html>
	   <head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	   	    <title>Use a Form to send data to a server</title>
            <script>
                function init(){
                    var d=$("#txt").val();
                    $.ajax({
                        async:true,
                        data:{"textt":d},
                        url:"test.php",
                        type:"GET",
                        success:function(data)
                        {
                            $("#im").attr("src",data);
                        }
                    });
                }
            </script>

            <script>
                function erase()
                {
                    document.body.innerHTML="";
                }
                class MenuElement
                {
                    constructor(m,str,n)
                    {
                        this.menu=m;
                        this.string=str;
                        this.strObj=document.createTextNode(str);
			this.separator=document.createTextNode("\xa0\xa0\xa0");
                        this.p=document.createElement("p");
                        this.p.appendChild(this.strObj);                        
                        this.p.appendChild(this.separator); 

                        this.numObj=document.createTextNode(n+"\xa0\xa0\xa0");                        
                        this.p.appendChild(this.numObj);                        
                        

                        this.b=document.createElement("input");
                        this.b.type="button";
                        this.p.appendChild(this.b);
                        this.b.onclick=del;
                        m.p2.appendChild(this.p);

                        currentMenu.map.set(this.b,this);
                    }


                }
                  function del()
                {
                    var el=currentMenu.map.get(this);
                    el.menu.p2.removeChild(el.p);
                    el.menu.map.delete(this);

                }
                var currentMenu;
                class Menu
                {
                    constructor()
                    {
                        this.p1=document.createElement("p");
                        this.in1=document.createElement("input");
                        this.in1.type="text";
                        this.p1.appendChild(this.in1);
                        this.in2=document.createElement("input");
                        this.in2.type="text";
                        this.p1.appendChild(this.in2);
                        this.addbtn=document.createElement("input");
                        this.addbtn.type="button";
                        this.addbtn.name="ADD";
                        this.addbtn.onclick=clickedMenu;
                        this.p1.appendChild(this.addbtn);

                        this.p2=document.createElement("p");
                        this.runButton=document.createElement("input");
                        this.runButton.type="button";
                        this.runButton.onclick=initRun;
                        

                        this.map=new Map();
                        
                    }
                    show()
                    {
                        erase();
                        document.body.appendChild(this.p1);
                        document.body.appendChild(this.p2);
                        document.body.appendChild(this.runButton);
                    }


                }
                function clickedMenu()
                {
                    if(currentMenu.in1.value=="" || currentMenu.in2.value=="")return;
                    if(isNaN(currentMenu.in2.value))return;
                    var nel=new MenuElement(currentMenu,currentMenu.in1.value,currentMenu.in2.value);
                    
                    currentMenu.in1.value="";
                    currentMenu.in2.value="";
                }

                function showMenu()
                {
                    currentMenu=new Menu();
                    currentMenu.show();
                }








                var currentRun;
                const maxMedia=20;
                class Run{
                    
                    constructor()
                    {
                        this.list=new Array();
                        this.readyMedia=[];
                        this.mediaId=0;
			    this.sumNum=0;
			    this.sumTotal=0;
                        
                        var vals=currentMenu.p2.children;
                        for(var i=0;i<vals.length;i++)
                        {
                            var txt=vals.item(i).childNodes.item(0).data;
                            var num=Number(vals.item(i).childNodes.item(2).data);
                            

                            var perPage,total,pageCache;
				
				var url="https://gelbooru.com/index.php?page=post&s=list&tags="+txt+"&pid=0";
				var firstD=getHTML(url);
					
				perPage=firstD.getElementsByClassName("thumbnail-container").item(0).children.length;
					
				var pages=firstD.getElementsByClassName("pagination").item(0).children;
					
				if(pages.length>1){
					var pagestrs=pages.item(pages.length-1).getAttribute("href").split("=");
					total=Number(pagestrs[pagestrs.length-1]);
					pageCache=new Array(total/perPage +1);
					var lastURL="https://gelbooru.com/index.php?page=post&s=list&tags="+txt+"&pid="+total;
						
						
					var lastD=getHTML(lastURL);
					total+=Number(lastD.getElementsByClassName("thumbnail-container").item(0).children.length);
				}
				else
				{
					total=firstD.getElementsByClassName("thumbnail-container").item(0).children.length;						
					pageCache=new Array(1);						
					}
			
                            


                            this.list.push({"txt":txt,"perPage":perPage,"total":total,"pageCache":pageCache,"num":num});        
				this.sumNum+=num;
			    this.sumTotal+=total;
			}
                        
                        this.running=false;
                        this.queueInterval=1000;                        

                    }

                    run()
                    {
                        this.running=true;
                        this.queueLoop();
                        this.mediaLoop();

                    }
			
			loadPageCache(page,pageDoc,selected)
				{
					var container=pageDoc.getElementsByClassName("thumbnail-container").item(0).children;
					this.list[selected]["pageCache"][page]=new Array(container.length);
					
					for(var i=0;i<container.length;i++)
					{
						this.list[selected]["pageCache"][page][i]=container.item(i).children.item(0).id.slice(1);
					}
				}
			
			randomSelect1()
			{
				var numc=Math.random()*this.sumNum;
				var selected=-1;
				for(var i=0;selected==-1;i++)
				{
					numc-=this.list[i]["num"];
					if(numc<0)
						selected=i;
				}
				
				var idx=Math.floor(Math.random()*this.list[selected]["total"]);
				
				var page=Math.floor(idx/this.list[selected]["perPage"]);
				var off=idx%this.list[selected]["perPage"];
				
				if(!this.list[selected]["pageCache"][page])
				{
					var pageDoc=getHTML("https://gelbooru.com/index.php?page=post&s=list&tags="+this.list[selected]["txt"]+"&pid="+(page*this.list[selected]["perPage"]));
					this.loadPageCache(page,pageDoc,selected);
				}
				
				var id=this.list[selected]["pageCache"][page][off];
				
				var  imgurl="https://gelbooru.com/index.php?page=post&s=view&id="+id;
				return imgurl;
			}

                    queueLoop()
                    {
                        if(!this.running)return;

                        if(this.readyMedia.length<10)
                        {
				var url=this.randomSelect1();
				this.queueMedia(url);



                        }
                        

                        setTimeout(this.queueLoop.bind(this),this.queueInterval);                        
                    }

                    queueMedia(url)
                    {
				var pageDoc=getHTML(url);
				var isImage=pageDoc.getElementById("right-col");
				
				if(isImage!=null){
						
						
					var realurl=isImage.children.item(0).children.item(1).src;	
					this.queueImg(realurl);
					
				}
                    }

                    queueImg(url)
                    {
                        var id="local://data/data"+this.mediaId;
                        this.mediaId++;
			    this.mediaId%=maxMedia;
                        $.ajax({
                        async:true,
                        data:{"url":url,"id":id},
                        url:"loadPic.php",
                        type:"GET",
                        success:function(data)
                        {
                            var img=document.createElement("img");
                            
                            img.onload=function()
                            {
                                currentRun.readyMedia.push({"type":"img","img":this,"time":5000});
                            }
				img.src=data;
                        }
                        });

                    }

                    queueVid(url)
                    {

                    }



                    mediaLoop()
                    {
                        if(!this.running)return;
			 if(this.readyMedia.length==0)
			{
				setTimeout(this.mediaLoop.bind(this),1000);  
				return;
			}
                        var t=this.readyMedia[0];
                        this.readyMedia.shift();
                        if(t["type"]=="img")
                            this.showImg(t);

                        setTimeout(this.mediaLoop.bind(this),t["time"]);
                    }

                    showImg(t)
                    {
                        var img=t["img"];
                        var ratio=img.naturalHeight/img.naturalWidth;
                        var width=window.innerWidth;
                        var height=width*ratio;
                        if(height>window.innerHeight)
                        {
                            height=window.innerHeight;
                            width=height/ratio;
                        }
                        img.width=width;
                        img.height=height;
                        
                        erase();
                        document.body.appendChild(img);
                        
                    }

                    
                }

                var parser;
                function getHTML(url)
                {
                    if(!parser)parser=new DOMParser();
                    var result;
                    $.ajax({
                        async:false,
                        data:{"url":url},
                        url:"getHTML.php",
                        type:"GET",
                        success:function(data)
                        {
                            result=data;
                        }
                    });
                    return parser.parseFromString(result,"text/html");
                }

                function initRun()
                {
                    currentRun=new Run();
			currentRun.run();
                }
            </script>


	   </head>
	   <body>
           twertfsdfs
           <input type="text" id="txt">
           <input type="button" onclick= "showMenu()">
           
        
    </body>
</html>

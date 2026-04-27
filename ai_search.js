function aiSearch(){

let q = document.getElementById("aiQuery").value;

fetch("ai_search.php",{
method:"POST",
headers:{
"Content-Type":"application/json"
},
body:JSON.stringify({query:q})
})
.then(r=>r.json())
.then(data=>{
document.getElementById("aiResult").innerHTML=data.html;
});

}
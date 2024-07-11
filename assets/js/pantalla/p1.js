getCitas();

function getCitas(){

    $.get('pantallas/getCitas')
    .done(d => {
        $("#addData").html('')
        let da = JSON.parse(d);
        
        da["citas"].forEach((e,i) =>{            
            $("#addData").append("<tr>"+
            "<td class='t-center'>"+(i+1)+"</td>"+
           
            "</tr>")
        })
        setTimeout(() => {
            getCitas()
          }, "5000");   
    })
}


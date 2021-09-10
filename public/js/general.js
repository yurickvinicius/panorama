var url = 'http://'+$(location).attr('host')

$(document).ready(function(){        
    
    reloadDolarFutureB3()
    resultDolarNrFuture()


    ////// Reload para carregar base de dados possicao no dolar
    setInterval(function(){
       
        reloadDolarFutureB3()
        resultDolarNrFuture()

    }, 2700000);
    
    
})

function resultDolarNrFuture(){
    
    $.ajax({
        url: url + '/result/dolar',
        dataType: "json",
        cache: false,
        success: function (datas) {
            ///alert(user.name);
            console.log(datas)

            $('#resultPosDol').html(datas);

        },
    });

}

function reloadDolarFutureB3(){   
    
    var data = new Date();
    var hour = data.getHours();
    ///var min = data.getMinutes();

    if(hour === 2){

        $.ajax({
            url: url + '/reload/dolar/future/b3',
            dataType: "json",
            cache: false,
            success: function (datas) {
    
                console.log(datas)

            },
        });

    }

}
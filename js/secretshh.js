 setInterval(function() {
            
            $('.such.overlay').append(
                '<span style="position: absolute; left: ' + Math.random()  *100 + '%;top: ' + Math.random()  *100 + '%;font-size: ' + Math.max(20, (Math.random() * 50 + 24)) + 'px; color:' + randomFrom(suchcolors) + ';">'
                    + r(dogefix) +
                '</span>');
                var suchnumber = $("span").length;
                if (suchnumber > 8 )
                {
                    $('.such span:nth-child(1)').remove();
                }
        }, 2500);
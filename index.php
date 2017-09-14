<?php 
date_default_timezone_set('Europe/London'); // If you want the NEWS to be displayed at your local timezone edit the default Europe/London timezone according to this: http://php.net/manual/en/timezones.php 
include_once 'config.php'; 

	class RssAgent {
	var $title = array(),
		$link = array(),
		$description = array(),
		$category = array(),
		$guid = array(),
		$pubDate = array();	
	   	function __construct( $urlFeed = NULL ) {
			$content = @file_get_contents( $urlFeed ); 
			$x = new SimpleXmlElement( $content );
			foreach( $x->channel->item as $entry )
			{
				array_push( $this->title, strip_tags( $entry->title ) );
				array_push( $this->link, $entry->link );
				array_push( $this->description, strip_tags( $entry->description ) );
				array_push( $this->category, $entry->category );
				array_push( $this->guid, $entry->guid );
				array_push( $this->pubDate, $entry->pubDate );
			}
		}	
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://cdn0.iconfinder.com/data/icons/fatcow/16/coin_stack_gold.png">
    <title>My Coin Portfolio</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  </head>

  <body>

    <div class="container">
    
    <div class="row">
    <div class="col-md-6">
    <h1>My Coin Portfolio</h1>
    </div> 
    <div class="col-md-2 col-md-offset-4">
    <p style="text-align:right;"><i>
    <?php echo $mymotto; ?>
    <br>
    - <?php echo $myusername; ?>
    </i></p>    
    </div>
    </div>
    
    <ul class="nav nav-tabs" style="margin-top: 10px;">
    <li class="active"><a href="#summary" data-toggle="tab">My Summary</a></li>
    <li><a href="#portfolio" data-toggle="tab">My Coin Portfolio</a></li>
    <li><a href="#watchlist" data-toggle="tab">My Watchlist</a></li>
    <li><a href="#news" data-toggle="tab">News</a></li>
    <li><a href="#community" data-toggle="tab">Community Posts</a></li>
    </ul>

    <div class="tab-content">

<!-- start MY COIN PORTFOLIO -->
    
    <div class="tab-pane" id="portfolio">

    <table class="table table-striped">

    <thead> 
    <tr> 
    <th>#</th> 
    <th>Name</th> 
    <th>Price</th>
    <th>Change (24h)</th> 
    <th>Market Cap</th> 
    <th>Quantity</th> 
    <th>Investment</th> 
    <th>Balance</th> 
    <th>Profit/Loss</th> 
    </tr> 
    </thead> 
    <tbody> 

    <?php 
    
    $coininv = null;
    $coinbal = null;

    for ($i = 1; $i <= $coinnr; $i++) {
    
    $coinid = ${'coin'.$i.'id'}; // Get coin's number and id
    
    // Get JSON respons from CoinMarketCap
    $json = file_get_contents('https://api.coinmarketcap.com/v1/ticker/'.$coinid.'/?convert='.$currency.'');
    $coin = json_decode($json, true);
    
    // Set currency and price based on currency
    if ($currency == "USD"){$currency_symbol = "&nbsp;$"; $coinprice = $coin[0]['price_usd']; $marketcap = $coin[0]['market_cap_usd'];}
    if ($currency == "CAD"){$currency_symbol = "&nbsp;$"; $coinprice = $coin[0]['price_cad']; $marketcap = $coin[0]['market_cap_cad'];}
    if ($currency == "EUR"){$currency_symbol = "&nbsp;&euro;"; $coinprice = $coin[0]['price_eur']; $marketcap = $coin[0]['market_cap_eur'];} 
    if ($currency == "GBP"){$currency_symbol = "&nbsp;&pound;"; $coinprice = $coin[0]['price_gbp']; $marketcap = $coin[0]['market_cap_gbp'];} 
    if ($currency == "CNY"){$currency_symbol = "&nbsp;&yen;"; $coinprice = $coin[0]['price_cny']; $marketcap = $coin[0]['market_cap_cny'];} 
    if ($currency == "BTC"){$currency_symbol = "&nbsp;&#3647;"; $coinprice = $coin[0]['price_btc']; $marketcap = $coin[0]['market_cap_btc'];} 
    
    // Set coin name
    $coinname = $coin[0]['name'];
    $coinsymbol = $coin[0]['symbol'];

    // Set coin percent change for the last 24 hours
    $precent_change_24h = $coin[0]['percent_change_24h'];
    
    // Start table
    echo '<tr><th scope="row">'.$i.'</th>'; // Echo row number
    echo '<td><img style="width:24px;" alt="'.$coinid.'" src="https://files.coinmarketcap.com/static/img/coins/32x32/'.$coinid.'.png">&nbsp;<a href="https://coinmarketcap.com/currencies/'.$coinid.'/#charts" target="_blank">'.$coinname.'</a>';
    if (${'coin'.$i.'mined'} == "yes") 
    {echo '&nbsp;<span style="font-size:12px;" class="label label-primary">MINED</span>';}
    echo '</td>';
    echo '<td>'.$coinprice.$currency_symbol.'</td>'; // Echo coin price
    
    // Check coin percent change and display color label according to its course
    echo '<td>'; 
    if ($precent_change_24h > 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-success">+'.$precent_change_24h.' %</span>';} 
    if ($precent_change_24h == 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-default">'.$precent_change_24h.' %</span>';}
    if ($precent_change_24h < 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-danger">'.$precent_change_24h.' %</span>';}
    echo '</td>';

    echo '<td>'.number_format($marketcap).$currency_symbol.'</td>'; // Echo market cap
    
    echo '<td>'.${'coin'.$i.'qua'}.' '.$coinsymbol.'</td>'; // Echo your coin quantity
    echo '<td>'.${'coin'.$i.'inv'}.$currency_symbol.'</td>'; // Echo your coin investment
    if ($currency == "BTC") {${'coin'.$i.'bal'}=${'coin'.$i.'qua'} * $coinprice;} else {${'coin'.$i.'bal'}=round(${'coin'.$i.'qua'} * $coinprice,2);} // Set your coin balance calculation, if currency is BTC display all decimals.
    echo '<td>'.${'coin'.$i.'bal'}.$currency_symbol.'</td>'; // Echo your coin balance
    ${'coin'.$i.'pro'} = (${'coin'.$i.'qua'} * $coinprice) - ${'coin'.$i.'inv'}; // Set the loss/profit calculation

    // Check coin loss/profit and display color label according to its course 
    echo '<td>';
    if (${'coin'.$i.'pro'} > 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-success">+'.round(${'coin'.$i.'pro'},2).$currency_symbol.'</span>';} 
    if (${'coin'.$i.'pro'} == 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-default">'.round(${'coin'.$i.'pro'},2).$currency_symbol.'</span>';} 
    if (${'coin'.$i.'pro'} < 0)
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-danger">'.round(${'coin'.$i.'pro'},2).$currency_symbol.'</span>';}
    echo '</td></tr>';
    
    $coininv += ${'coin'.$i.'inv'}; // Add this coin investment to the previous ones
    $coinbal += ${'coin'.$i.'bal'}; // Add this coin balance to the previous ones
    
    } 
    ?>
    </tbody>
    </table>
    
    <hr>
    
    <table style="font-weight:bold;">

    <tr>
    <td>
    <p style="font-weight:normal;">
    &#8618;&nbsp;Coin Investment:&nbsp;
    </p>
    </td>
    <td>
    <p>
    <span style="font-size:14px;" class="label label-default"><?php echo $coininv.$currency_symbol; ?></span>
    </p>
    </td>
    </tr>
    
    <tr>
    <td>
    <p style="font-weight:normal;">
    &#8618;&nbsp;Exchange fees, etc.:&nbsp;
    </p>
    </td>
    <td>
    <p>
    <span style="font-size:14px;" class="label label-default"><?php $fees = $grossinv-$coininv; echo $fees.$currency_symbol; ?></span>
    </p>
    </td>
    </tr>
    
    <?php
    if ($doyoumine == "yes") 
    {echo '   
    <tr>
    <td>
    <p style="font-weight:normal;">
    &#8618;&nbsp;Mining expenses:&nbsp;
    </p>
    </td>
    <td>
    <p>
    <span style="font-size:14px;" class="label label-default">'.$mininginv.$currency_symbol.'</span>
    </p>
    </td>
    </tr>';} else {$mininginv = 0;}
    ?>
    
    <tr>
    <td>
    <p>
    Total Investment:&nbsp;
    </p>
    </td>
    <td>
    <p>
    <span style="font-size:14px;" class="label label-warning"><?php echo $grossinv+$mininginv.$currency_symbol; ?></span>
    </p>
    </td>
    </tr>

    <tr>
    <td>
    <p>
    Total Balance:&nbsp;
    </p>
    </td>
    <td>
    <p>
    <span style="font-size:14px;" class="label label-primary"><?php echo round($coinbal,2).$currency_symbol; ?></span>
    </p>
    </td>
    </tr>

    <tr>
    <td>
    <p>
    <?php 
    $totalpro = $coinbal-($grossinv+$mininginv); 
    if ($totalpro > 0) 
    {echo 'Total Profit/Loss:&nbsp;</p></td><td><p><span style="font-size:14px;" class="label label-success">+'.round($totalpro,2).$currency_symbol.'</span>';} 
    if ($totalpro == 0) 
    {echo 'Total Profit/Loss:&nbsp;</p></td><td><p><span style="font-size:14px;" class="label label-default">'.round($totalpro,2).$currency_symbol.'</span>';}
    if ($totalpro < 0) 
    {echo 'Total Profit/Loss:&nbsp;</p></td><td><p><span style="font-size:14px;" class="label label-danger">'.round($totalpro,2).$currency_symbol.'</span>';}
    ?>
    </p>
    </td>
    </tr>

    </table>
    
    </div>

<!-- end MY COIN PORTFOLIO -->

<!-- start MY WATCHLIST -->

    <div class="tab-pane" id="watchlist">

    <table class="table table-striped">

    <thead> 
    <tr> 
    <th>#</th> 
    <th>Name</th> 
    <th>Price</th>
    <th>Change (1h)</th> 
    <th>Change (24h)</th> 
    <th>Change (7d)</th> 
    <th>Market Cap</th> 
    <th>Volume (24h)</th> 
    <th>Circulating Supply</th> 
    <th>Total Supply</th>
    <th>Links</th>
    </tr> 
    </thead> 
    <tbody> 

    <?php 

    for ($w = 1; $w <= $watchcoinnr; $w++) {
    
    $watchcoinid = ${'watchcoin'.$w.'id'}; // Get coin's number and id
    
    // Get JSON respons from CoinMarketCap
    $watchjson = file_get_contents('https://api.coinmarketcap.com/v1/ticker/'.$watchcoinid.'/?convert='.$watchcurrency.'');
    $watchcoin = json_decode($watchjson, true);
    
    // Set currency and price based on currency
    if ($watchcurrency == "USD"){$watchcurrency_symbol = "&nbsp;$"; $watchcoinprice = $watchcoin[0]['price_usd']; $watchmarketcap = $watchcoin[0]['market_cap_usd']; $watchvolume = $watchcoin[0]['24h_volume_usd'];}
    if ($watchcurrency == "CAD"){$watchcurrency_symbol = "&nbsp;$"; $watchcoinprice = $watchcoin[0]['price_cad']; $watchmarketcap = $watchcoin[0]['market_cap_cad']; $watchvolume = $watchcoin[0]['24h_volume_cad'];}
    if ($watchcurrency == "EUR"){$watchcurrency_symbol = "&nbsp;&euro;"; $watchcoinprice = $watchcoin[0]['price_eur']; $watchmarketcap = $watchcoin[0]['market_cap_eur']; $watchvolume = $watchcoin[0]['24h_volume_eur'];} 
    if ($watchcurrency == "GBP"){$watchcurrency_symbol = "&nbsp;&pound;"; $watchcoinprice = $watchcoin[0]['price_gbp']; $watchmarketcap = $watchcoin[0]['market_cap_gbp']; $watchvolume = $watchcoin[0]['24h_volume_gbp'];} 
    if ($watchcurrency == "CNY"){$watchcurrency_symbol = "&nbsp;&yen;"; $watchcoinprice = $watchcoin[0]['price_cny']; $watchmarketcap = $watchcoin[0]['market_cap_cny']; $watchvolume = $watchcoin[0]['24h_volume_cny'];} 
    if ($watchcurrency == "BTC"){$watchcurrency_symbol = "&nbsp;&#3647;"; $watchcoinprice = $watchcoin[0]['price_btc']; $watchmarketcap = $watchcoin[0]['market_cap_btc']; $watchvolume = $watchcoin[0]['24h_volume_btc'];} 
    
    // Set coin name
    $watchcoinname = $watchcoin[0]['name'];
    $watchcoinsymbol = $watchcoin[0]['symbol'];
    
    // Set coin percent change for the last 24 hours
    $watchprecent_change_1h = $watchcoin[0]['percent_change_1h'];
    $watchprecent_change_24h = $watchcoin[0]['percent_change_24h'];
    $watchprecent_change_7d = $watchcoin[0]['percent_change_7d'];

    $watchsupply = $watchcoin[0]['available_supply'];
    $watchtotalsupply = $watchcoin[0]['total_supply'];
    
    // Start table
    echo '<tr><th scope="row">'.$w.'</th>'; // Echo row number
    echo '<td><img style="width:24px;" alt="'.$watchcoinid.'" src="https://files.coinmarketcap.com/static/img/coins/32x32/'.$watchcoinid.'.png">&nbsp;<a href="https://coinmarketcap.com/currencies/'.$watchcoinid.'/#charts" target="_blank">'.$watchcoinname.'</a></td>'; // Display coin image
    echo '<td>'.$watchcoinprice.$watchcurrency_symbol.'</td>'; // Echo coin price

    // Check coin percent change and display color label according to its course
    echo '<td>'; 
    if ($watchprecent_change_1h > 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-success">+'.$watchprecent_change_1h.' %</span>';} 
    if ($watchprecent_change_1h == 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-default">'.$watchprecent_change_1h.' %</span>';}
    if ($watchprecent_change_1h < 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-danger">'.$watchprecent_change_1h.' %</span>';}
    echo '</td>';

    // Check coin percent change and display color label according to its course
    echo '<td>'; 
    if ($watchprecent_change_24h > 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-success">+'.$watchprecent_change_24h.' %</span>';} 
    if ($watchprecent_change_24h == 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-default">'.$watchprecent_change_24h.' %</span>';}
    if ($watchprecent_change_24h < 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-danger">'.$watchprecent_change_24h.' %</span>';}
    echo '</td>';

    // Check coin percent change and display color label according to its course
    echo '<td>'; 
    if ($watchprecent_change_7d > 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-success">+'.$watchprecent_change_7d.' %</span>';} 
    if ($watchprecent_change_7d == 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-default">'.$watchprecent_change_7d.' %</span>';}
    if ($watchprecent_change_7d < 0) 
    {echo '<span style="font-size:14px; font-weight:normal;" class="label label-danger">'.$watchprecent_change_7d.' %</span>';}
    echo '</td>';

    echo '<td>'.number_format($watchmarketcap).$watchcurrency_symbol.'</td>'; // Echo market cap
   
    echo '<td>'.number_format($watchvolume).$watchcurrency_symbol.'</td>'; // Echo market cap

    echo '<td>'.number_format($watchsupply).' '.$watchcoinsymbol.'</td>'; // Echo market cap

    echo '<td>'.number_format($watchtotalsupply).' '.$watchcoinsymbol.'</td>'; // Echo market cap
    
    echo'<td>';
    if (isset(${'watchcoin'.$w.'web'})) {
    echo '<a href="'.${'watchcoin'.$w.'web'}.'" target="_blank"><img src="https://cdn2.iconfinder.com/data/icons/bitsies/128/Application-16.png" alt="Website" title="Website"></a>&nbsp;';
    }
    if (isset(${'watchcoin'.$w.'paper'})) {
    echo '<a href="'.${'watchcoin'.$w.'paper'}.'" target="_blank"><img src="https://cdn2.iconfinder.com/data/icons/file-8/128/file-expand_Pdf-16.png" alt="Whitepaper" title="Whitepaper"></a>';
    }
    echo '</td>';
    
    } 
    ?>
    </tbody>
    </table>
    
    </div>

<!-- end MY WATCHLIST -->

<!-- start MY SUMMARY -->

    <div class="tab-pane active" id="summary">
    
    <h4 style="margin-top:20px;text-align:center;">Portfolio performance</h4>
    <?php
    $totalpercentage = ($totalpro/$grossinv) * 100;
    if ($totalpro > 0) 
    {echo '<h1 style="text-align:center;font-weight:bold;color:#5cb85c;">&#11014;&nbsp;'.round(abs($totalpercentage),2).'%</h1>';}
    if ($totalpro == 0) 
    {echo '<h1 style="text-align:center;font-weight:bold;color:#000;">0.00%</h1>';}
    if ($totalpro < 0) 
    {echo '<h1 style="text-align:center;font-weight:bold;color:#d9534f;">&#11015;&nbsp;'.round(abs($totalpercentage),2).'%</h1>';}
    ?>
    
    <div style="width: 100%; min-height: 450px;" id="piechart"></div>

    </div>

<!-- end MY SUMMARY -->


<!-- start NEWS -->

    <div class="tab-pane" id="news">
    
<?php 
$RSS = new RssAgent( $newslink );
echo '<ul>';
for( $n = 0; $n < $newsnumber; $n++ )
{ 
$parse = parse_url($RSS->link[$n]);
echo '<li><h4><strong><a href="' . $RSS->link[$n] . '" target="_blank">' . $RSS->title[$n] . '</a>&nbsp;<span style="font-size:14px;">'.$parse['host'].' - '.date('d M Y H:i', strtotime($RSS->pubDate[$n])).'</span></strong></h4>';
}
echo '</ul>';
?>

    </div>

<!-- end NEWS -->

<!-- start COMMUNITY POSTS -->

    <div class="tab-pane" id="community">
    
<?php 
$RSS2 = new RssAgent( $communitypostslink );
echo '<ul>';
for( $c = 0; $c < $communitypostsnumber; $c++ )
{ 
$parse2 = parse_url($RSS2->link[$c]);
echo '<li><h4><strong><a href="' . $RSS2->link[$c] . '" target="_blank">' . $RSS2->title[$c] . '</a>&nbsp;<span style="font-size:14px;">'.$parse2['host'].'</span></strong></h4>';
}
echo '</ul>';
?>

    </div>

<!-- end COMMUNITY POSTS -->


    </div>

    <hr>
    <p><small>Made with <a href="https://coinmarketcap.com/api/" target="_blank">CoinMarketCap API</a>, <a href="https://developers.google.com/chart/" target="_blank">Google Charts</a>, <a href="https://www.daniweb.com/programming/web-development/code/287265/php-rss-reader" target="_blank">RssAgent</a> &amp; <a href="https://getbootstrap.com/" target="_blank">Bootstrap</a> by <a href="https://github.com/bitr8jorge/mycoinportfolio" target="_blank">bitr8jorge</a></small></p>
    <h5 style="margin-bottom:25px;">tiny.cc/mycoinportfolio</h5>

    </div><!-- /.container -->
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Coins', 'Investment'],
          
    <?php 
    for ($s = 1; $s <= $coinnr; $s++) {   
    $summarycoinid = ${'coin'.$s.'id'}; // Get coin's number and id   
    // Get JSON respons from CoinMarketCap
    $summaryjson = file_get_contents('https://api.coinmarketcap.com/v1/ticker/'.$summarycoinid);
    $summarycoin = json_decode($summaryjson, true);
    $summarycoinsymbol = $summarycoin[0]['symbol'];
    $summarycoininv = ${'coin'.$s.'inv'};
    if (${'coin'.$s.'mined'} = "yes"){$summaryminedcoin = $summarycoin[0]['symbol'];}
    
    echo "['".$summarycoinsymbol."', ".$summarycoininv/($grossinv+$mininginv)."],";
    }
    echo "['Exchange fees, etc.',".$fees/($grossinv+$mininginv)."],";
    echo "['Mining ".$summaryminedcoin."',".$mininginv/($grossinv+$mininginv)."]";
    ?>
        ]);

        var options = {
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
      
      $(window).resize(function(){
      drawChart();
      });
      
    </script>
	
    
  </body>
</html>










	

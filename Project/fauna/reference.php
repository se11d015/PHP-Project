<?php
require("config/inc.cfg.php");
require("templates/inc.main_head.php");
require("config/inc.db.php");
require("config/inc.functions.php");
require("notification/inc.alerts.php")

?>
<body>
<div class="container">
  <div class="row">
    <div class="span12">
      <div class="headerlogo"> <a class="logo1" href="http://www.mne.mn/"></a> <a class="logo2" href="http://www.irimhe.namem.gov.mn"></a> </div>
      <div class="headertitle">
        <h2><?php echo $_MY_CONF["SITE_NAME"]; ?></h2>
      </div>
      <?php require("templates/inc.main_nav.php"); ?>
    </div>
  </div>
  <div class="main-content">
    <div class="row">
      <div class="span3">
        <?php require("templates/inc.front_left.php"); ?>
      </div>
      <div class="span9">
        <div class="list-table">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th><span class="title">Ашигласан ном хэвлэл</span></th>
              </tr>
            </thead>
          </table>
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>№</th>
                <th>Номын зураг</th>
                <th>Нэр</th>
                <th>Зохиогчид</th>
                <th>Хэвлэлийн газар</th>
                <th>Хот</th>
                <th>Он</th>
                <th>Хуудас</th> 
              </tr>
            </thead>          
            <tbody>
              <tr>
                <td>1</td>
                <td><img src="images/nom1.jpg" alt="image" width="100px"/></td>
                <td>Монгол  улсын улаан ном (Mongolian  Red Book)</td>
                <td>Хамтын  бүтээл</td>
                <td>ADMON хэвлэлийн газар</td>
                <td>Улаанбаатар</td>
                <td>2013</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>2</td>
                <td><img src="images/nom2.jpg" alt="image" width="100px"/></td>
                <td>Mongolian Red List of Birds 2011 (English)</td>
                <td>R. Seidler, D. Sumiya, N. Tseveenmyadag, S. Bayarkhuu, J.E.M. Baillie, Sh. Boldbaatar, Ch. Uugangayar</td>
                <td>Admon Printing</td>
                <td>Ulaanbaatar</td>
                <td>2011</td>
                <td>&nbsp;</td>                                                              
              </tr>
              <tr>
                <td>3</td>
                <td><img src="images/nom4.jpg" alt="image" width="100px"/></td>
                <td><p>Монгол орны хоёр нутагтан, мөлхөгчдийн улаан данс</p>
                  <p>Mongolian Red List of Reptiles and Amphibians (English)</p>
                <p>&nbsp;</p></td>
                <td><p>Хаянхярваагийн Тэрбиш, Хорлоогийн Мөнхбаяр, E.L. Clark, Жавзансүрэнгийн Мөнхбат, E.M. Monks</p>
                  <p>Terbish, Kh., Munkhbayar, Kh., Clark, E.L., Munkhbat, J. and Monks, E.M.</p>
                <p>&nbsp;</p></td>
                <td>ADMON хэвлэлийн газар</td>
                <td>Улаанбаатар</td>
                <td>2008</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>4</td>
                <td><img src="images/nom5.jpg" alt="image" width="100px"/></td>
                <td><p>Монгол улсын хөхтөн амьтны улаан  данс</p>
                    <p>Mongolian Red List of Mammals (English)</p></td>
                <td><p>С. Дуламцэрэн, J. E. M. Baillie, Н. Батсайхан, Р. Самъяа, M. Stubbe</p>
                    <p>S. Dulamtseren, J. E. M. Baillie, N. Batsaikhan, R. Samiya and M. Stubbe</p></td>
                <td>ADMON хэвлэлийн газар</td>
                <td>Улаанбаатар</td>
                <td>2006</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>5</td>
                <td><img src="images/nom3.jpg" alt="image" width="100px"/></td>
                <td><p>Монгол  орны загасны Улаан данс</p>
                    <p>Mongolian Red List of Fishes (English)</p></td>
                <td><p>J. Ocock, Г. Баасанжав, J. E. M. Baillie, М. Эрдэнэбат, M.  Kottelat, Б. Мэндсайхан, K. Smith</p>
                    <p>J. Ocock, G. Baasanjav, J. E. M. Baillie, M. Erdenebat, M. Kottelat, B. Mendsaikhan and K. Smith</p></td>
                <td>ADMON хэвлэлийн газар</td>
                <td>Улаанбаатар</td>
                <td>2006</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>6</td>
                <td><img src="images/nom6.jpg" alt="image" width="100px"/></td>
                <td><p>&quot;Монгол орны ан амьтад&quot; танин мэдэхүйн СД</p>
                </td>
                <td>Байгаль орчны мэдээллийн төв</td>
                <td>&nbsp;</td>
                <td>Улаанбаатар</td>
                <td>2001</td>
                <td>&nbsp;</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <?php	require("templates/inc.footer.php"); ?>
    </div>
  </div>
</div>
</body>
</html>
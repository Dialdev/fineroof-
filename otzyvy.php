<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Отзывы клиентов");
$APPLICATION->SetTitle("Отзывы");
?>
<style>
  .container_reviews {   width: 75%;
  border: 2px solid #ccc;
  background-color: #eee;
  border-radius: 5px; /* скругление углов блока */
  padding: 16px; /* внутренние поля */
  margin: 16px auto; /* внешние отступы */
  width:100%;
}

  .container_reviews img {
  float: left; /* обтекание слева */
  margin-right: 20px; /* пространство между аватаркой и абзацем */
  border-radius: 50%; /* скругляет аватарку */
  width: 90px;
}

.container_reviews span {
  font-size: 18px;
  margin-right: 15px;
}

</style>


<!-- Страница находится в разработке.... <br>
<br>
Отзывы.<br> -->
 <div class="container_reviews">
  <!--<img src="avatar-female.png" alt="avatar">-->
  <p><span>Марина Белова</span> г. Волгоград</p>
  <p>Качество товара отличное, доставка быстрая.</p>
</div>
<div class="container_reviews">
   <!--<img src="avatar-female.png" alt="avatar">-->
  <p><span>Алексей Фролов</span> г. Волгоград</p>
  <p>Спасибо!</p>
</div>
</dl>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
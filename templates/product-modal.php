<div id="editProductModal" class="modal">
  <div class="modal-content edit-modal">
    <span class="close">&times;</span>
    <h2 class="modal-title">Редактирование товара</h2>

    <form class="edit-form" action="server/update_product.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-id">
      <input type="hidden" name="existing_image" id="edit-existing-image">

      <div class="edit-modal-grid">
        <label class="edit-label">Изображения</label>
        <div class="edit-field">
          <div class="img-upload">
            <img src="" alt="Товар" id="edit-preview" class="preview-image">
            <input type="file" name="image" id="productImage" hidden>
            <div>
              <label for="productImage" class="upload-btn">Загрузить</label>
            </div>
          </div>
        </div>

        <label class="edit-label">Артикул</label>
        <input class="edit-field" type="text" name="sku" id="edit-sku">

        <label class="edit-label">Название</label>
        <input class="edit-field" type="text" name="name" id="edit-name" required>

        <label class="edit-label">Описание</label>
        <input class="edit-field" type="text" name="description" id="edit-description" required>

        <label class="edit-label">Цена</label>
        <input class="edit-field" type="number" name="price" id="edit-price" required>

        <label class="edit-label">Наличие</label>
        <input class="edit-field" type="number" name="stock" id="edit-stock">

        <label class="edit-label">Категория</label>
        <select class="edit-field" name="category" id="edit-category">
          <option value="Мужской">Мужская</option>
          <option value="Женский">Женская</option>
          <option value="Бренд">Бренд</option>
          <option value="Распродажа">Распродажа</option>
          <option value="Детская">Детская</option>
        </select>

        <label class="edit-label">Статус заказа</label>
        <select class="edit-field" name="order_status" id="edit-order-status">
          <option value="Ожидает">Ожидает</option>
          <option value="В обработке">В обработке</option>
          <option value="Доставляется">Доставляется</option>
          <option value="Доставлен">Доставлен</option>
          <option value="Отменён">Отменён</option>
        </select>

        <label class="edit-label">Статус оплаты</label>
        <select class="edit-field" name="payment_status" id="edit-payment-status">
          <option value="Не оплачен">Не оплачен</option>
          <option value="Оплачен">Оплачен</option>
          <option value="Возврат">Возврат</option>
        </select>
      </div>

      <div class="edit-btn-wrapper">
        <button type="submit" class="modal-button">Сохранить</button>
      </div>
    </form>
  </div>
</div>

<script>
  const modal = document.getElementById("editProductModal");

  // Открытие модального окна для редактирования
  document.querySelectorAll(".admin-edit").forEach(button => {
    button.addEventListener("click", function () {
      document.querySelector(".modal-title").textContent = "Редактирование товара";
      document.querySelector(".edit-form").action = "server/update_product.php";

      document.getElementById("edit-id").value = this.dataset.id;
      document.getElementById("edit-sku").value = this.dataset.sku;
      document.getElementById("edit-name").value = this.dataset.name;
      document.getElementById("edit-description").value = this.dataset.description;
      document.getElementById("edit-price").value = this.dataset.price;
      document.getElementById("edit-stock").value = this.dataset.stock;
      document.getElementById("edit-category").value = this.dataset.category;
      document.getElementById("edit-preview").src = this.dataset.image;
      document.getElementById("edit-existing-image").value = this.dataset.image;
      document.getElementById("edit-order-status").value = this.dataset.orderstatus;
      document.getElementById("edit-payment-status").value = this.dataset.paymentstatus;
      modal.style.display = "flex";
    });
  });

  // Открытие модального окна для добавления
  document.querySelector(".admin-add").addEventListener("click", () => {
    document.querySelector(".modal-title").textContent = "Добавить товар";
    document.querySelector(".edit-form").action = "server/add_product.php";

    document.getElementById("edit-id").value = "";
    document.getElementById("edit-sku").value = "";
    document.getElementById("edit-name").value = "";
    document.getElementById("edit-description").value = "";
    document.getElementById("edit-price").value = "";
    document.getElementById("edit-stock").value = "";
    document.getElementById("edit-category").value = "1";
    document.getElementById("edit-preview").src = "";
    document.getElementById("edit-existing-image").value = "";
    document.getElementById("edit-order-status").value = "Ожидает";
    document.getElementById("edit-payment-status").value = "Не оплачен";
    modal.style.display = "flex";
  });

  document.querySelector("#editProductModal .close").addEventListener("click", () => {
    modal.style.display = "none";
  });

  window.addEventListener("click", e => {
    if (e.target === modal) modal.style.display = "none";
  });
</script>
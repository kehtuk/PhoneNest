<div id="editProductModal" class="modal">
  <div class="modal-content edit-modal">
    <span class="close">&times;</span>
    <h2 class="modal-title">Редактирование товара</h2>

    <form class="edit-form" action="server/update_product.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-id">
      <input type="hidden" name="existing_image" id="edit-existing-image">

        <div class="edit-columns-3">
          <!-- Левая колонка: базовая информация -->
          <div class="edit-column">
            <label class="edit-label">Изображение</label>
            <div class="edit-field img-upload">
              <img src="" alt="Товар" id="edit-preview" class="preview-image">
              <input type="file" name="image" id="productImage" hidden>
              <label for="productImage" class="upload-btn">Загрузить</label>
            </div>

            <label class="edit-label">Артикул</label>
            <input class="edit-field" type="text" name="sku" id="edit-sku">

            <label class="edit-label">Название</label>
            <input class="edit-field" type="text" name="name" id="edit-name" required>

            <label class="edit-label">Описание</label>
            <textarea class="edit-field" name="description" id="edit-description" rows="4" style="resize: vertical;" required></textarea>

            <label class="edit-label">Цена</label>
            <input class="edit-field" type="number" name="price" id="edit-price" step="0.01" required>

            <label class="edit-label">Наличие</label>
            <input class="edit-field" type="number" name="stock" id="edit-stock">
          </div>

          <!-- Средняя колонка: первая часть технических характеристик -->
          <div class="edit-column">
            <label class="edit-label">Бренд</label>
            <input class="edit-field" type="text" name="brand" id="edit-brand">

            <label class="edit-label">Размер экрана</label>
            <input class="edit-field" type="text" name="screen_size" id="edit-screen_size">

            <label class="edit-label">Разрешение экрана</label>
            <input class="edit-field" type="text" name="screen_resolution" id="edit-screen_resolution">

            <label class="edit-label">ОЗУ</label>
            <input class="edit-field" type="text" name="ram" id="edit-ram">

            <label class="edit-label">Память</label>
            <input class="edit-field" type="text" name="storage" id="edit-storage">

            <label class="edit-label">Батарея</label>
            <input class="edit-field" type="text" name="battery_capacity" id="edit-battery">

            <label class="edit-label">ОС</label>
            <input class="edit-field" type="text" name="os" id="edit-os">

            <label class="edit-label">Основная камера</label>
            <input class="edit-field" type="text" name="camera_main" id="edit-camera_main">
          </div>

          <!-- Правая колонка: оставшиеся характеристики -->
          <div class="edit-column">
            <label class="edit-label">Категория</label>
            <input class="edit-field" type="text" name="category" id="edit-category">

            <label class="edit-label">Фронтальная камера</label>
            <input class="edit-field" type="text" name="camera_front" id="edit-camera_front">

            <label class="edit-label">Процессор</label>
            <input class="edit-field" type="text" name="cpu" id="edit-cpu">

            <label class="edit-label">Тип SIM</label>
            <input class="edit-field" type="text" name="sim_type" id="edit-sim">

            <label class="edit-label">Сети</label>
            <input class="edit-field" type="text" name="network" id="edit-network">

            <label class="edit-label">Вес</label>
            <input class="edit-field" type="text" name="weight" id="edit-weight">

            <label class="edit-label">Габариты</label>
            <input class="edit-field" type="text" name="dimensions" id="edit-dimensions">

            <label class="edit-label">Цвет</label>
            <input class="edit-field" type="text" name="color" id="edit-color">
          </div>
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

      // Заполняем поля из data-атрибутов
      document.getElementById("edit-id").value = this.dataset.id;
      document.getElementById("edit-sku").value = this.dataset.sku;
      document.getElementById("edit-name").value = this.dataset.name;
      document.getElementById("edit-description").value = this.dataset.description;
      document.getElementById("edit-price").value = this.dataset.price;
      document.getElementById("edit-stock").value = this.dataset.stock;
      document.getElementById("edit-category").value = this.dataset.category;
      document.getElementById("edit-brand").value = this.dataset.brand;
      document.getElementById("edit-preview").src = "/img/" + this.dataset.image;
      document.getElementById("edit-existing-image").value = this.dataset.image;
      document.getElementById("edit-screen_size").value = this.dataset.screen_size;
      document.getElementById("edit-screen_resolution").value = this.dataset.screen_resolution;
      document.getElementById("edit-ram").value = this.dataset.ram;
      document.getElementById("edit-storage").value = this.dataset.storage;
      document.getElementById("edit-battery").value = this.dataset.battery;
      document.getElementById("edit-os").value = this.dataset.os;
      document.getElementById("edit-camera_main").value = this.dataset.camera_main;
      document.getElementById("edit-camera_front").value = this.dataset.camera_front;
      document.getElementById("edit-cpu").value = this.dataset.cpu;
      document.getElementById("edit-sim").value = this.dataset.sim;
      document.getElementById("edit-network").value = this.dataset.network;
      document.getElementById("edit-weight").value = this.dataset.weight;
      document.getElementById("edit-dimensions").value = this.dataset.dimensions;
      document.getElementById("edit-color").value = this.dataset.color;

      modal.style.display = "flex";
    });
  });

  // Открытие модального окна для добавления
  document.querySelector(".admin-add").addEventListener("click", () => {
    document.querySelector(".modal-title").textContent = "Добавить товар";
    document.querySelector(".edit-form").action = "server/add_product.php";

    const fieldsToClear = [
      "edit-id", "edit-sku", "edit-name", "edit-description", "edit-price", "edit-stock",
      "edit-category", "edit-brand", "edit-existing-image",
      "edit-screen_size", "edit-screen_resolution", "edit-ram", "edit-storage", "edit-battery",
      "edit-os", "edit-camera_main", "edit-camera_front", "edit-cpu", "edit-sim", "edit-network",
      "edit-weight", "edit-dimensions", "edit-color"
    ];

    fieldsToClear.forEach(id => {
      const field = document.getElementById(id);
      if (field) field.value = "";
    });

    document.getElementById("edit-preview").src = "";

    modal.style.display = "flex";
  });

  // Закрытие модального окна
  document.querySelector("#editProductModal .close").addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Открытие модального окна для удаления
  window.addEventListener("click", e => {
    if (e.target === modal) modal.style.display = "none";
  });
  document.querySelectorAll('.admin-delete').forEach(button => {
    button.addEventListener('click', () => {
        if (!confirm('Вы уверены, что хотите удалить этот товар?')) return;

        const productId = button.dataset.id;

        fetch('server/delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${encodeURIComponent(productId)}`
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === 'success') {
                location.reload(); // обновить страницу
            } else {
                alert('Ошибка при удалении товара.');
            }
        })
        .catch(() => alert('Ошибка запроса к серверу.'));
    });
});
</script>
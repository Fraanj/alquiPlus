<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catálogo de Máquinas</title>
  <style>
    /* Reset básico */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9fafb;
      color: #1a202c; /* gris oscuro */
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
    }

    /* Título principal */
    h1 {
      font-size: 2.25rem; /* 36px */
      font-weight: 800;
      margin-bottom: 32px;
      border-bottom: 2px solid #cbd5e0; /* gris claro */
      padding-bottom: 12px;
      text-align: center;
      color: #2c5282; /* azul oscuro */
    }

    /* Filtros */
    .grid-filtros {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
      margin-bottom: 40px;
    }

    input[type="text"],
    select {
      padding: 12px 16px;
      border: 1.5px solid #cbd5e0;
      border-radius: 10px;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus,
    select:focus {
      border-color: #3182ce; /* azul vivo */
      box-shadow: 0 0 6px #3182ce;
    }

    /* Catálogo */
    .grid-catalogo {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 32px;
    }

    .card {
      background-color: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 20px rgba(66, 153, 225, 0.1);
      overflow: hidden;
      transition: box-shadow 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .card:hover {
      box-shadow: 0 12px 25px rgba(66, 153, 225, 0.3);
    }

    .card img {
      width: 100%;
      max-width: 400px;
      height: 220px;
      object-fit: cover;
      border-bottom-left-radius: 16px;
      border-bottom-right-radius: 16px;
    }

    .card-content {
      padding: 20px 25px;
      width: 100%;
    }

    .card-content h2 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 12px;
      color: #dd6b20; /* naranja cálido */
    }

    .card-content p {
      color: #4a5568; /* gris medio */
      margin-bottom: 8px;
      font-size: 1rem;
    }

    .card-content p strong {
      color: #38a169; /* verde */
      font-weight: 700;
    }

    /* Footer */
    footer {
      margin-top: 60px;
      border-top: 1.5px solid #cbd5e0;
      padding-top: 24px;
      text-align: center;
      font-size: 0.9rem;
      color: #718096; /* gris más claro */
    }

    footer a {
      color: #3182ce;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    footer a:hover {
      color: #2c5282;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    
<header style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
  <!-- Logo izquierda -->
  <div style="display: flex; align-items: center; gap: 12px;">
    <div style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden;">
  <img src="/images/mannylogo.png" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;" />
     </div>
  </div>

  <!-- Título centrado -->
  <h1 style="font-size: 2.5rem; font-weight: 900; color: #dd6b20; margin: 0; text-align: center; flex-grow: 1;">
    MANNY Maquinarias
  </h1>

  <!-- Ícono usuario derecha -->
  <div style="width: 40px; height: 40px; background-color: #cbd5e0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Usuario" style="width: 24px; height: 24px;" />
  </div>
</header>
    <div class="grid-filtros">
      <input type="text" placeholder="Buscar por nombre..." />
      <select>
        <option value="">Filtrar por sucursal</option>
        <option value="La Plata">La Plata</option>
        <option value="Berazategui">Berazategui</option>
        <option value="Quilmes">Quilmes</option>
        <option value="Avellaneda">Avellaneda</option>
        <option value="Moreno">Moreno</option>
      </select>
      <select>
        <option value="">Ordenar por precio</option>
        <option value="asc">Menor a mayor</option>
        <option value="desc">Mayor a menor</option>
      </select>
    </div>

    <div class="grid-catalogo">
      <div class="card">
        <img src="/images/tractorjohn.avif" alt="Tractor John Deere" />
        <div class="card-content">
          <h2>Tractor John Deere</h2>
          <p>Precio por día: <strong>$2500</strong></p>
          <p>Sucursal: La Plata</p>
        </div>
      </div>

      <div class="card">
        <img src="/images/retroex.jpeg" alt="Retroexcavadora CAT" />
        <div class="card-content">
          <h2>Retroexcavadora CAT</h2>
          <p>Precio por día: <strong>$3800</strong></p>
          <p>Sucursal: Berazategui</p>
        </div>
      </div>

      <div class="card">
        <img src="/images/minibob.jpg" alt="Mini Cargadora Bobcat" />
        <div class="card-content">
          <h2>Mini Cargadora Bobcat</h2>
          <p>Precio por día: <strong>$3100</strong></p>
          <p>Sucursal: Quilmes</p>
        </div>
      </div>

      <!-- Nuevas máquinas -->
      <div class="card">
        <img src="/images/camion.jpeg" alt="Camión Volvo" />
        <div class="card-content">
          <h2>Camión Volvo</h2>
          <p>Precio por día: <strong>$4200</strong></p>
          <p>Sucursal: Avellaneda</p>
        </div>
      </div>

      <div class="card">
        <img src="/images/komatsu.jpeg" alt="Excavadora Komatsu" />
        <div class="card-content">
          <h2>Excavadora Komatsu</h2>
          <p>Precio por día: <strong>$4600</strong></p>
          <p>Sucursal: Moreno</p>
        </div>
      </div>

      <div class="card">
        <img src="/images/grua.jpeg" alt="Grúa Torre" />
        <div class="card-content">
          <h2>Grúa Torre</h2>
          <p>Precio por día: <strong>$5000</strong></p>
          <p>Sucursal: La Plata</p>
        </div>
      </div>

      <div class="card">
        <img src="/images/cargadora.jpeg" alt="Palas Cargadoras" />
        <div class="card-content">
          <h2>Palas Cargadoras</h2>
          <p>Precio por día: <strong>$3300</strong></p>
          <p>Sucursal: Berazategui</p>
        </div>
      </div>
    </div>

    <footer>
      <p>
        Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> |
        Tel: <a href="tel:+542215922204">+54 221 592 2204</a>
      </p>
      <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
    </footer>
  </div>
</body>
</html>

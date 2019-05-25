<head>
  <title>Formulário</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>

  <div class="container">
    <h2>Cadastro</h2>
    <div class="panel-group">

      <div class="panel panel-success">
        <div class="panel-heading">Insira seus dados</div>
        <div class="panel-body">

          <form action="{{ route('pessoas.store') }}" method="post" id="save_form">

            {{ csrf_field() }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" enctype="multipart/form-data">

            <div class="form-group">
              <label for="nome">Nome:</label>
              <input type="text" class="form-control" name="nome" id="nome">
            </div>
            <div class="form-group">
              <label for="cidade">Cidade:</label>
              <input type="text" class="form-control" name="cidade" id="cidade">
            </div>
            <button type="submit" id="salvar_form" class="btn btn-success">Salvar</button>
            <a onclick="location.href = '{{ route('pessoas.index') }}';" class="btn btn-default">Cancelar</a>

          </form>

        </div>
      </div>

</body>

</html>
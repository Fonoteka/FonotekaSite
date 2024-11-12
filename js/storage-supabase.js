document.addEventListener("DOMContentLoaded", function () {
  if (typeof supabase !== "undefined" && supabase.createClient) {
    const supabaseClient = supabase.createClient(
      "https://zaxdehkvsnwabvoyyesz.supabase.co",
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI"
    );

    const formulario = document.getElementById("form-guia");
    var tituloGuia = document.getElementById("titulo");
    var descGuia = document.getElementById("desc");
    var autorGuia = document.getElementById("autor");
    var linkGuia = document.getElementById("link");

    formulario.addEventListener("submit", async function (e) {
      e.preventDefault();

      await vereficaGuia();
      const fileName = await uploadImagem();
      const fileURL = await getImagemURL();
      cadastraGuia();

      async function vereficaGuia() {
        try {
          const { data, error } = await supabaseClient
            .from("tb_guias")
            .select("nomeguia")
            .eq("nomeguia", tituloGuia.value);

          if (data.length > 0) {
            msgPop("Guia já cadastrado");
            return;
          }
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }

      async function uploadImagem() {
        const fileInput = document.getElementById("imagem");
        const file = fileInput.files[0];

        if (!file) {
          msgPop("Adicione um arquivo");
        }

        const fileName = `${Date.now()}-${file.name}`;

        try {
          const { data, error } = await supabaseClient.storage
            .from("images")
            .upload(fileName, file);

          if (error) {
            msgPop(`ERRO: ${error.message}`);
            return;
          }

          return fileName;
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }

      async function getImagemURL() {
        try {
          const { data } = supabaseClient.storage
            .from("images")
            .getPublicUrl(fileName);

          const fileURL = data.publicUrl;
          return fileURL;
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }

      async function cadastraGuia() {
        try {
          const { error } = await supabaseClient.from("tb_guias").insert({
            nomeguia: tituloGuia.value,
            descricao: descGuia.value,
            nomeautor: autorGuia.value,
            linkGuia: linkGuia.value,
            path_imagem: fileURL,
          });

          if (!error) {
            msgPop("Cadastro efetuado com sucesso!!");
          }
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  if (typeof supabase !== "undefined" && supabase.createClient) {
    const supabaseClient = supabase.createClient(
      "https://zaxdehkvsnwabvoyyesz.supabase.co",
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI"
    );

    const formulario = document.getElementById("form-guia");

    formulario.addEventListener("submit", async function (e) {
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

        msgPop("Upload bem-sucedido!");
      } catch (error) {
        msgPop(`ERRO: ${error}`);
        return;
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", () => {
  if (typeof supabase !== "undefined") {
    const supabaseClient = supabase.createClient(
      "https://zaxdehkvsnwabvoyyesz.supabase.co",
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI"
    );

    var nome;
    var email;
    var telefone;
    var genero;
    const fileInput = document.getElementById("file");
    var file;

    const idMentor = localStorage.getItem("idMentor");
    const path_img = localStorage.getItem("path_img");

    const btnSalvar = document.getElementById("btnSalvar");
    btnSalvar.addEventListener("click", async () => {
      file = fileInput.files[0];
      let fileURL = null;

      loading(true);
      if (file) {
        fileURL = await getImagemURL();
      }
      await atualizaMentor(fileURL);
      loading(false);
      window.location.reload();
    });

    async function atualizaMentor(fileURL) {
      nome = document.getElementById("nome").value;
      email = document.getElementById("email").value;
      telefone = document.getElementById("telefone").value;
      genero = document.getElementById("genero").value;

      try {
        const { data, error } = await supabaseClient
          .from("tb_cadastro")
          .update({
            nome: nome,
            email: email,
            telefone: telefone,
            genero: genero,
            path_imagem: fileURL !== null ? fileURL : path_img,
          })
          .eq("idmentor", idMentor);

        console.log(error);

        msgPop("Atualização feita com sucesso");
      } catch (error) {
        msgPop(`ERRO: ${error}`);
        return;
      }
    }

    async function uploadImage() {
      const fileName = `${Date.now()}-${file.name}`;

      try {
        const { data, error } = await supabaseClient.storage
          .from("imagesCadastro")
          .upload(fileName, file);
        console.log(error);
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
      const fileName = await uploadImage();
      try {
        const { data } = supabaseClient.storage
          .from("imagesCadastro")
          .getPublicUrl(fileName);
        const fileURL = data.publicUrl;
        await localStorage.setItem("path_img", fileURL);
        return fileURL;
      } catch (error) {
        msgPop(`ERRO: ${error}`);
        return;
      }
    }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  if (typeof supabase !== "undefined" && supabase.createClient) {
    const supabaseClient = supabase.createClient(
      "https://zaxdehkvsnwabvoyyesz.supabase.co",
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI"
    );

    const formulario = document.getElementById("form-ativ");
    var nomeAtividade = document.getElementById("nomeAtividade");
    var descAtividade = document.getElementById("descAtividade");
    var pontos = document.getElementById("pontos");
    var nivelAutismo = document.getElementById("nivelAutismo");
    var dataPostagem = document.getElementById("dataPostagem");
    var dataEntrega = document.getElementById("dataEntrega");
    var idAluno = document.getElementById("idAluno");
    var idMentor = document.getElementById("idMentor");

    formulario.addEventListener("submit", async function (e) {
      e.preventDefault();

      const fileName = await uploadImagem();
      const fileURL = await getImagemURL();
      cadastraAtividade();

      async function uploadImagem() {
        const fileInput = document.getElementById("imagem");
        const file = fileInput.files[0];

        if (!file) {
          msgPop("Adicione um arquivo");
        }

        const fileName = `${Date.now()}-${file.name}`;

        try {
          const { data, error } = await supabaseClient.storage
            .from("imagesAtividade")
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
            .from("imagesAtividade")
            .getPublicUrl(fileName);

          const fileURL = data.publicUrl;
          return fileURL;
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }

      async function cadastraAtividade() {
        try {
          const { error } = await supabaseClient.from("tb_atividades").insert({
            nomeatividade: nomeAtividade.value,
            descatividade: descAtividade.value,
            idmentor: idMentor.value,
            qtnpontos: pontos.value,
            nivelautismo: nivelAutismo.value,
            datapostagem: dataPostagem.value,
            dataentrega: dataEntrega.value,
            path_imagem: fileURL,
            idaluno: idAluno.value,
            fonema1: "teste",
            fonema2: "teste",
            fonema3: "teste",
            fonema4: "teste",
            fonema5: "teste",
          });

          if (!error) {
            msgPop("Cadastro efetuado com sucesso!!");
          } else {
            console.log(error.message);
          }
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }
    });
  }
});

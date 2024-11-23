document.addEventListener("DOMContentLoaded", async function () {
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
    const fileInput = document.getElementById("imagem");

    const idAtividade = localStorage.getItem("idAtividade");
    var dataAtividade;

    if (idAtividade !== null) {
      loading(false);
      dataAtividade = await pegaInfoAtiv();
      nomeAtividade.value = dataAtividade[0].nomeatividade;
      descAtividade.value = dataAtividade[0].descatividade;
      pontos.value = dataAtividade[0].qtnpontos;
      nivelAutismo.value = dataAtividade[0].nivelautismo;
      let isoDatePostagem = dataAtividade[0].datapostagem;
      dataPostagem.value = isoDatePostagem.split("T")[0];
      let isoDateEntrega = dataAtividade[0].dataentrega;
      dataEntrega.value = isoDateEntrega.substring(0, 19).replace("T", " ");
      idAluno.value = dataAtividade[0].idaluno;
    }

    formulario.addEventListener("submit", async function (e) {
      e.preventDefault();

      loading(true);
      idAtividade !== null ? atualizaAtividade() : cadastraAtividade();
      loading(false);

      async function atualizaAtividade() {
        var path_imagem = null;
        const file = fileInput.files[0];
        if (file) {
          path_imagem = await getImagemURL();
        }
        try {
          const { error } = await supabaseClient
            .from("tb_atividades")
            .update({
              nomeatividade: nomeAtividade.value,
              descatividade: descAtividade.value,
              qtnpontos: pontos.value,
              nivelautismo: nivelAutismo.value,
              datapostagem: dataPostagem.value,
              dataentrega: dataEntrega.value,
              idaluno: idAluno.value,
              path_imagem:
                path_imagem == null ? dataAtividade.path_imagem : path_imagem,
            })
            .eq("idatividade", idAtividade);

          if (!error) {
            msgPop("Atualização efetuada com sucesso!!");
          } else {
            console.log(error.message);
          }
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      }

      async function cadastraAtividade() {
        const fileURL = await getImagemURL();
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

      async function uploadImagem() {
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
        const fileName = await uploadImagem();
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
    });

    async function pegaInfoAtiv() {
      try {
        const { data, error } = await supabaseClient
          .from("tb_atividades")
          .select()
          .eq("idatividade", idAtividade);
        return data;
      } catch (error) {
        msgPop(`ERRO: ${error.message}`);
        return;
      }
    }
  }
});

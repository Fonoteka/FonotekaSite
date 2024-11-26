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
    var idMentor = localStorage.getItem("idMentor");
    var fonema1 = document.getElementById("fonema1");
    var fonema2 = document.getElementById("fonema2");
    var fonema3 = document.getElementById("fonema3");
    var fonema4 = document.getElementById("fonema4");
    var fonema5 = document.getElementById("fonema5");
    const fileInput = document.getElementById("imagem");

    const idAtividade = localStorage.getItem("idAtividade");
    var dataAtividade;

    if (idAtividade !== null) {
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

    selectAlunos();

    formulario.addEventListener("submit", async function (e) {
      e.preventDefault();

      loading(true);
      idAtividade !== null
        ? await atualizaAtividade()
        : await cadastraAtividade();
      limpaCampos();
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
        let fonema1Valor = fonema1.value;
        fonema1Valor = fonema1Valor.toLowerCase();
        let fonema2Valor = fonema2.value;
        fonema2Valor = fonema2Valor.toLowerCase();
        let fonema3Valor = fonema3.value;
        fonema3Valor = fonema3Valor.toLowerCase();
        let fonema4Valor = fonema4.value;
        fonema4Valor = fonema4Valor.toLowerCase();
        let fonema5Valor = fonema5.value;
        fonema5Valor = fonema5Valor.toLowerCase();
        try {
          const { error } = await supabaseClient.from("tb_atividades").insert({
            nomeatividade: nomeAtividade.value,
            descatividade: descAtividade.value,
            idmentor: idMentor,
            qtnpontos: pontos.value,
            nivelautismo: nivelAutismo.value,
            datapostagem: dataPostagem.value,
            dataentrega: dataEntrega.value,
            path_imagem: fileURL,
            idaluno: idAluno.value,
            fonema1: fonema1Valor,
            fonema2: fonema2Valor,
            fonema3: fonema3Valor,
            fonema4: fonema4Valor,
            fonema5: fonema5Valor,
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
        localStorage.removeItem("idAtividade");
        return data;
      } catch (error) {
        msgPop(`ERRO: ${error.message}`);
        return;
      }
    }

    async function procuraAlunos() {
      try {
        const { data, error } = await supabaseClient
          .from("tb_cadastroaluno")
          .select("idaluno, nome")
          .eq("idmentor", idMentor);
        return data;
      } catch (error) {
        msgPop(`ERRO: ${error}`);
        return;
      }
    }

    async function selectAlunos() {
      const select_alunos = document.querySelector("#idAluno");
      const alunos_lista = await procuraAlunos();
      alunos_lista.forEach((aluno) => {
        const option = document.createElement("option");
        const textNome = document.createTextNode(aluno.nome.toUpperCase());
        option.value = aluno.idaluno;
        option.appendChild(textNome);
        select_alunos.appendChild(option);
      });
    }

    function limpaCampos() {
      nomeAtividade.value = "";
      descAtividade.value = "";
      pontos.value = "";
      nivelAutismo.value = "";
      dataPostagem.value = "";
      dataEntrega.value = "";
      idAluno.value = "";
    }
  }
});

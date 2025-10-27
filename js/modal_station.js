import ListaEstacoes from "./modal_station.js";
import React, { useState } from "react";

export default function ListaEstacoes() {
  const [estacoes, setEstacoes] = useState([
    { id: 1, nome: "Estação de Trem Central", status: "Fechado Permanentemente" },
    { id: 2, nome: "Bucarein", status: "Fechado Permanentemente" },
    { id: 3, nome: "Boa Vista", status: "Fechado Permanentemente" },
    { id: 4, nome: "Glória", status: "Fechado Permanentemente" },
    { id: 5, nome: "Floresta", status: "Fechado Permanentemente" },
    { id: 6, nome: "S1", status: "Aberto" },
    { id: 7, nome: "S2", status: "Aberto" },
    { id: 8, nome: "S3", status: "Aberto" },
  ]);

  const [modalAberto, setModalAberto] = useState(false);
  const [estacaoEditando, setEstacaoEditando] = useState(null);
  const [novoNome, setNovoNome] = useState("");
  const [novoStatus, setNovoStatus] = useState("Aberto");

  // Abrir o modal com dados da estação
  const abrirModal = (estacao) => {
    setEstacaoEditando(estacao);
    setNovoNome(estacao.nome);
    setNovoStatus(estacao.status);
    setModalAberto(true);
  };

  // Salvar alterações
  const salvarEdicao = () => {
    setEstacoes((prev) =>
      prev.map((e) =>
        e.id === estacaoEditando.id
          ? { ...e, nome: novoNome, status: novoStatus }
          : e
      )
    );
    setModalAberto(false);
  };

  return (
    <div style={{ padding: 40 }}>
      <h1 style={{ textAlign: "center" }}>Lista de Estações</h1>

      <div style={styles.grid}>
        {estacoes.map((estacao) => (
          <div key={estacao.id} style={styles.card}>
            <h3>{estacao.nome}</h3>
            <p
              style={{
                color: estacao.status === "Aberto" ? "green" : "red",
                fontWeight: 500,
              }}
            >
              {estacao.status}
            </p>
            <button style={styles.btnEditar} onClick={() => abrirModal(estacao)}>
              Editar
            </button>
          </div>
        ))}
      </div>

      {/* MODAL */}
      {modalAberto && (
        <div style={styles.overlay}>
          <div style={styles.modal}>
            <h2>Editar Estação</h2>

            <label>Nome:</label>
            <input
              type="text"
              value={novoNome}
              onChange={(e) => setNovoNome(e.target.value)}
              style={styles.input}
            />

            <label>Status:</label>
            <select
              value={novoStatus}
              onChange={(e) => setNovoStatus(e.target.value)}
              style={styles.input}
            >
              <option value="Aberto">Aberto</option>
              <option value="Fechado Permanentemente">
                Fechado Permanentemente
              </option>
            </select>

            <div style={styles.botoes}>
              <button style={styles.btnSalvar} onClick={salvarEdicao}>
                Salvar
              </button>
              <button
                style={styles.btnCancelar}
                onClick={() => setModalAberto(false)}
              >
                Cancelar
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

const styles = {
  grid: {
    display: "grid",
    gridTemplateColumns: "repeat(auto-fill, minmax(250px, 1fr))",
    gap: "20px",
    marginTop: "20px",
  },
  card: {
    background: "#fff",
    borderRadius: "12px",
    padding: "16px",
    boxShadow: "0 2px 6px rgba(0,0,0,0.1)",
    display: "flex",
    flexDirection: "column",
    alignItems: "flex-start",
    gap: "6px",
  },
  btnEditar: {
    marginTop: "10px",
    background: "#6c63ff",
    color: "#fff",
    border: "none",
    padding: "6px 12px",
    borderRadius: "6px",
    cursor: "pointer",
  },
  overlay: {
    position: "fixed",
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: "rgba(0,0,0,0.5)",
    display: "flex",
    alignItems: "center",
    justifyContent: "center",
    zIndex: 1000,
  },
  modal: {
    background: "#fff",
    borderRadius: "12px",
    padding: "20px",
    width: "350px",
    display: "flex",
    flexDirection: "column",
    gap: "10px",
  },
  input: {
    padding: "8px",
    borderRadius: "6px",
    border: "1px solid #ccc",
  },
  botoes: {
    display: "flex",
    justifyContent: "space-between",
    marginTop: "10px",
  },
  btnSalvar: {
    background: "#6c63ff",
    color: "#fff",
    border: "none",
    padding: "6px 12px",
    borderRadius: "6px",
    cursor: "pointer",
  },
  btnCancelar: {
    background: "#ccc",
    color: "#000",
    border: "none",
    padding: "6px 12px",
    borderRadius: "6px",
    cursor: "pointer",
  },
};

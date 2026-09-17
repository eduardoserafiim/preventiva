<?php 
function criarCardUsuario($usuario)
{ ?>
    <div class="cardUsuario" data-nome="<?= htmlspecialchars($usuario['nome']) ?>" data-usuario="<?= $usuario['usuario'] ?>" data-email="<?= htmlspecialchars($usuario['email']) ?>">
        <div class="imagemUsuario">
            <img src="../upload/usuarios/<?= !empty($usuario['nome_imagem']) ? $usuario['nome_imagem'] : 'default-usuario.png' ?>" alt="Algo está errado.">
        </div>
        <div class="conteudoUsuario">
            <div class="topoInformacoesUsuario">
                <div class="tituloUsuario">
                    <div class="flex">
                        <div class="tituloDetalhes">
                            <div class="nomeUsuarioDetalhado">
                                <p>Nome</p>
                                <h4 class="nomeUsuario"><?= htmlspecialchars($usuario['nome']) ?></h4>
                            </div>
                            <div class=usuarioUsuarioDetalhado">
                                <p>Usuário</p>
                                <h4 class="usuarioUsuario"><?= htmlspecialchars($usuario['usuario']) ?></h4>
                            </div>
                            <div class="senhaUsuarioDetalhado">
                                <p>Senha</p>
                                <h4 class="senhaUsuario">********</h4>
                            </div>
                            <div class="setorUsuarioDetalhado">
                                <p>Setor</p>
                                <h4 class="setorUsuario"><?= htmlspecialchars($usuario['nome_setor']) ?></h4>
                            </div>
                            <div class="privilegioUsuarioDetalhado">
                                <p>Privilégio</p>
                                <h4 class="privilegioUsuario"><?= htmlspecialchars($usuario['privilegio']) ?></h4>
                            </div>
                            <div class="unidadeUsuarioDetalhado">
                                <p>Unidade</p>
                                <h4 class="unidadeUsuario"><?= htmlspecialchars($usuario['nome_unidade']) ?></h4>
                            </div>
                            <div class="emailUsuarioDetalhado">
                                <p>Email</p>
                                <h4 class="emailUsuario"><?= htmlspecialchars($usuario['email']) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="opcoesUsuario">
                    <div class="configuracoesUsuario">
                        <a href="usuarios?url=editar&id=<?= $usuario['id'] ?>&tipo=usuario&informacoes=basicas">
                            <i class="fas fa-icon fa-solid fa-gear fa-xl anima"></i>
                        </a>
                    </div>
                    <?php if ($_SESSION['id'] != $usuario['id']): ?>
                        <div class="deletarUsuario">
                            <form action="../controllers/UsuariosController" method="POST">
                                <input type="hidden" name="acao" value="excluir">
                                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                <button style="background-color: inherit; border: none; color: red; cursor: pointer;" type="submit" onclick="confirmarExclusao(event)">
                                    <i class="fas fa-icon fa-solid fa-trash fa-xl"></i>
                                </button>
                            </form>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
<?php }
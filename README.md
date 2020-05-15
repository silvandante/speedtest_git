Speedtest que testa taxa de download e upload, detecta ISP e IP da conexão do usuário feito por DDSOL https://github.com/ddsol/speedtest.net

O projeto Speedtest_git usa o Speedtest de DDSOL de forma a ser executado como um serviço em background no Windows (com auxilio do AlwaysUp) e assim testa a internet do usuário de acordo com um intervalo definido por ele (ou padrão).

O Speedtest_git pode ser configurado e gerenciado a partir de uma página Web Admin Panel, onde também se gera relatórios sobre cada conexão (ISP e IP) detectado.

O serviço detecta automaticamente novas conexões e notifica ao usuário cada nova conexão, que pode ser renomeada de acordo com o desejo do usuário. Cada conexão é salva no banco de dados com identificador único, e a partir da execução do Speedtest por intervalo determinado pelo usuário, o sistema armazena o resultado do Speedtest associando a conexão ativa atual. Ao final é possível gerar relatório em gráfico.

CASO DE USO
![alt text](https://github.com/silvandante/speedtest_git/blob/master/caso%20de%20uso.png)

DIAGRAMA DE CLASSE
![alt text](https://github.com/silvandante/speedtest_git/blob/master/classe.png)

CONFIGURAÇÕES
![alt text](https://github.com/silvandante/speedtest_git/blob/master/dash.png)
Na tela “index.php” o usuário encontra as 3 opções de configuração do Speedtest assim como a visualização da configuração atual.

CONEXÕES
![alt text](https://github.com/silvandante/speedtest_git/blob/master/list.png)
Na tela “conexoes.php” o usuário pode gerenciar as conexões mudando o nome ou o pacote do serviço contratado.

RELATÓRIO
![alt text](https://github.com/silvandante/speedtest_git/blob/master/relatorio.png)
Na tela “charts.php” o usuário pode gerenciar os relatórios para cada conexão. Para isso basta selecionar a conexão desejada e opções de relatório desejadas e clicar em “gerar” que a tela abaixo surgirá:
![alt text](https://github.com/silvandante/speedtest_git/blob/master/chart.png)
E ao clicar no botão “Download PDF” o usuário é encaminhado para um .pdf do relatório gerado que pode ser baixado e guardado.

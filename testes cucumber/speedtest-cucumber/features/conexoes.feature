Feature: <Feature Name>
Testes de usabilidade sobre o painel de configuração do Speedtest Admin com cucumber e selenium driver -> feature: conexoes.php

  Scenario: <Scenario Name>
    Given Browse to web site "http://localhost/speedtest_admin/conexoes.php"
    When click in btn edit
    Then table item from "Lista de Conexões" <id,isp,ip,nome da conexão, pacote> data goes to "Nomear conexão" <id_connection,isp_connection, ip_connection, name_connection, pacote_connection>
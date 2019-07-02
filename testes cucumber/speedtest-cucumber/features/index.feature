Feature: Speedtest Cucumber
Testes de usabilidade sobre o painel de configuração do Speedtest Admin com cucumber e selenium driver -> feature: index.php

  Scenario: Testando modificação de intervaloTempo+maxServer+servidorEspecifico inputs em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input intervaloTempo receives <value>
    And input maxServer receives <value>
    And input servidorEspecifico  receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando modificação de intervaloTempo+maxServer inputs em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input intervaloTempo receives <value>
    And input maxServer receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando modificação de maxServer+servidorEspecifico inputs em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input maxServer receives <value>
    And input servidorEspecifico  receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando modificação de intervaloTempo+servidorEspecifico inputs em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input intervaloTempo receives <value>
    And input servidorEspecifico  receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando modificação de intervaloTempo input em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input intervaloTempo receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando modificação de maxServer input em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input maxServer receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando modificação de servidorEspecifico input em Configuração Speedtest
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When input servidorEspecifico  receives <value>
    And click save_button button
    Then update config must be successful

  Scenario: Testando botão openConfig da barra de navegação vertical do Speedtest Admin dentro de index.php
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When click openConfig button in left navbar
    Then index.php should be oppened

  Scenario: Testando botão openConnections barra de navegação vertical do Speedtest Admin dentro de index.php
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When click openConnections button in left navbar
    Then conexoes.php should be oppened

  Scenario: Testando botão openCharts barra de navegação vertical do Speedtest Admin dentro de index.php
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    When click openCharts button in left navbar
    Then chats.php should be oppened

  Scenario: Testando se a configuração atual está aparecendo na tabela de configuração atual em index.php
    Given Browse to web site "http://localhost/speedtest_admin/index.php"
    Then current_intervalo_table should not be null
    And current_maxserver_table should not be null
    And current_url_table should not be null
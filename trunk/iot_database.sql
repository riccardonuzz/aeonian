-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 16, 2017 alle 19:45
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot_database`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ambiente`
--

CREATE TABLE `ambiente` (
  `IDAmbiente` int(10) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `Descrizione` varchar(255) NOT NULL,
  `Impianto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `canale`
--

CREATE TABLE `canale` (
  `Canale` int(10) NOT NULL,
  `TerzaParte` int(10) NOT NULL,
  `TipologiaCanale` int(10) NOT NULL,
  `Valore` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `condivisione`
--

CREATE TABLE `condivisione` (
  `IDCondivisione` int(10) NOT NULL,
  `Sensore` int(10) NOT NULL,
  `Canale` int(10) NOT NULL,
  `TerzaParte` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `gestione`
--

CREATE TABLE `gestione` (
  `Impianto` int(10) NOT NULL,
  `Utente` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `impianto`
--

CREATE TABLE `impianto` (
  `IDImpianto` int(10) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `Nazione` varchar(64) NOT NULL,
  `Provincia` varchar(64) NOT NULL,
  `Indirizzo` varchar(64) NOT NULL,
  `CAP` char(5) NOT NULL,
  `Citta` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `IDNotifica` int(10) NOT NULL,
  `Regola` int(10) NOT NULL,
  `Messaggio` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `regolanotifica`
--

CREATE TABLE `regolanotifica` (
  `IDRegola` int(10) NOT NULL,
  `Sensore` int(10) NOT NULL,
  `Operazione` char(1) NOT NULL,
  `Valore` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `rilevazione`
--

CREATE TABLE `rilevazione` (
  `Sensore` int(10) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Valore` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruolo`
--

CREATE TABLE `ruolo` (
  `IDRuolo` int(1) NOT NULL,
  `Nome` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dump dei dati per la tabella `ruolo`
--

INSERT INTO `ruolo` (`IDRuolo`, `Nome`) VALUES
(1, 'amministratore'),
(2, 'cliente'),
(3, 'installatore');

-- --------------------------------------------------------

--
-- Struttura della tabella `sensore`
--

CREATE TABLE `sensore` (
  `IDSensore` int(10) NOT NULL,
  `Nome` varchar(128) NOT NULL,
  `Ambiente` int(10) NOT NULL,
  `TipologiaSensore` int(10) NOT NULL,
  `Marca` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `telefono`
--

CREATE TABLE `telefono` (
  `Numero` varchar(10) NOT NULL,
  `Utente` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `terzaparte`
--

CREATE TABLE `terzaparte` (
  `IDTerzaParte` int(10) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `Utente` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiacanale`
--

CREATE TABLE `tipologiacanale` (
  `IDTipologiaCanale` int(10) NOT NULL,
  `Nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipologiacanale`
--

INSERT INTO `tipologiacanale` (`IDTipologiaCanale`, `Nome`) VALUES
(1, 'e-mail');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiasensore`
--

CREATE TABLE `tipologiasensore` (
  `IDTipologiaSensore` int(10) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `UnitaMisura` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tipologiasensore`
--

INSERT INTO `tipologiasensore` (`IDTipologiaSensore`, `Nome`, `UnitaMisura`) VALUES
(1, 'Temperatura', 'Celsius'),
(2, 'Umidità', 'Percentuale'),
(3, 'Pressione', 'millibar'),
(4, 'Luxmetro', 'lux'),
(5, 'Fonometro', 'decibel'),
(6, 'Sensore di ossigeno', 'Percentuale'),
(7, 'Sensore di ossido di carbonio', 'Percentuale'),
(8, 'Sensore di monossido di carbonio', 'Percentuale'),
(9, 'PH-metro', ''),
(10, 'Contatore Geiger', 'microsievert');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `CodiceFiscale` char(16) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Nome` varchar(64) NOT NULL,
  `Cognome` varchar(64) NOT NULL,
  `Ruolo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`IDAmbiente`),
  ADD KEY `FKAmbiente154263` (`Impianto`);

--
-- Indici per le tabelle `canale`
--
ALTER TABLE `canale`
  ADD PRIMARY KEY (`Canale`,`TerzaParte`),
  ADD KEY `FKCanale733652` (`TerzaParte`),
  ADD KEY `FKCanale860104` (`TipologiaCanale`);

--
-- Indici per le tabelle `condivisione`
--
ALTER TABLE `condivisione`
  ADD PRIMARY KEY (`IDCondivisione`),
  ADD KEY `FKCondivisio715847` (`Canale`,`TerzaParte`),
  ADD KEY `FKCondivisio738689` (`Sensore`);

--
-- Indici per le tabelle `gestione`
--
ALTER TABLE `gestione`
  ADD PRIMARY KEY (`Impianto`,`Utente`),
  ADD KEY `FKGestione711467` (`Utente`),
  ADD KEY `FKGestione993324` (`Impianto`);

--
-- Indici per le tabelle `impianto`
--
ALTER TABLE `impianto`
  ADD PRIMARY KEY (`IDImpianto`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`IDNotifica`),
  ADD KEY `FKNotifica587003` (`Regola`);

--
-- Indici per le tabelle `regolanotifica`
--
ALTER TABLE `regolanotifica`
  ADD PRIMARY KEY (`IDRegola`),
  ADD KEY `FKRegolaNoti423157` (`Sensore`);

--
-- Indici per le tabelle `rilevazione`
--
ALTER TABLE `rilevazione`
  ADD PRIMARY KEY (`Sensore`,`Data`),
  ADD KEY `FKRilevazion404694` (`Sensore`);

--
-- Indici per le tabelle `ruolo`
--
ALTER TABLE `ruolo`
  ADD PRIMARY KEY (`IDRuolo`);

--
-- Indici per le tabelle `sensore`
--
ALTER TABLE `sensore`
  ADD PRIMARY KEY (`IDSensore`),
  ADD KEY `FKSensore574725` (`Ambiente`),
  ADD KEY `FKSensore137172` (`TipologiaSensore`);

--
-- Indici per le tabelle `telefono`
--
ALTER TABLE `telefono`
  ADD PRIMARY KEY (`Numero`),
  ADD KEY `FKTelefono907515` (`Utente`);

--
-- Indici per le tabelle `terzaparte`
--
ALTER TABLE `terzaparte`
  ADD PRIMARY KEY (`IDTerzaParte`),
  ADD KEY `FKTerzaParte496589` (`Utente`);

--
-- Indici per le tabelle `tipologiacanale`
--
ALTER TABLE `tipologiacanale`
  ADD PRIMARY KEY (`IDTipologiaCanale`);

--
-- Indici per le tabelle `tipologiasensore`
--
ALTER TABLE `tipologiasensore`
  ADD PRIMARY KEY (`IDTipologiaSensore`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`CodiceFiscale`),
  ADD KEY `FKUtente772807` (`Ruolo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `IDAmbiente` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `condivisione`
--
ALTER TABLE `condivisione`
  MODIFY `IDCondivisione` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `impianto`
--
ALTER TABLE `impianto`
  MODIFY `IDImpianto` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `IDNotifica` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `regolanotifica`
--
ALTER TABLE `regolanotifica`
  MODIFY `IDRegola` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `ruolo`
--
ALTER TABLE `ruolo`
  MODIFY `IDRuolo` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT per la tabella `terzaparte`
--
ALTER TABLE `terzaparte`
  MODIFY `IDTerzaParte` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `tipologiacanale`
--
ALTER TABLE `tipologiacanale`
  MODIFY `IDTipologiaCanale` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `tipologiasensore`
--
ALTER TABLE `tipologiasensore`
  MODIFY `IDTipologiaSensore` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ambiente`
--
ALTER TABLE `ambiente`
  ADD CONSTRAINT `FKAmbiente154263` FOREIGN KEY (`Impianto`) REFERENCES `impianto` (`IDImpianto`);

--
-- Limiti per la tabella `canale`
--
ALTER TABLE `canale`
  ADD CONSTRAINT `FKCanale733652` FOREIGN KEY (`TerzaParte`) REFERENCES `terzaparte` (`IDTerzaParte`),
  ADD CONSTRAINT `FKCanale860104` FOREIGN KEY (`TipologiaCanale`) REFERENCES `tipologiacanale` (`IDTipologiaCanale`);

--
-- Limiti per la tabella `condivisione`
--
ALTER TABLE `condivisione`
  ADD CONSTRAINT `FKCondivisio715847` FOREIGN KEY (`Canale`,`TerzaParte`) REFERENCES `canale` (`Canale`, `TerzaParte`),
  ADD CONSTRAINT `FKCondivisio738689` FOREIGN KEY (`Sensore`) REFERENCES `sensore` (`IDSensore`);

--
-- Limiti per la tabella `gestione`
--
ALTER TABLE `gestione`
  ADD CONSTRAINT `FKGestione711467` FOREIGN KEY (`Utente`) REFERENCES `utente` (`CodiceFiscale`),
  ADD CONSTRAINT `FKGestione993324` FOREIGN KEY (`Impianto`) REFERENCES `impianto` (`IDImpianto`);

--
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `FKNotifica587003` FOREIGN KEY (`Regola`) REFERENCES `regolanotifica` (`IDRegola`);

--
-- Limiti per la tabella `regolanotifica`
--
ALTER TABLE `regolanotifica`
  ADD CONSTRAINT `FKRegolaNoti423157` FOREIGN KEY (`Sensore`) REFERENCES `sensore` (`IDSensore`);

--
-- Limiti per la tabella `rilevazione`
--
ALTER TABLE `rilevazione`
  ADD CONSTRAINT `FKRilevazion404694` FOREIGN KEY (`Sensore`) REFERENCES `sensore` (`IDSensore`);

--
-- Limiti per la tabella `sensore`
--
ALTER TABLE `sensore`
  ADD CONSTRAINT `FKSensore137172` FOREIGN KEY (`TipologiaSensore`) REFERENCES `tipologiasensore` (`IDTipologiaSensore`),
  ADD CONSTRAINT `FKSensore574725` FOREIGN KEY (`Ambiente`) REFERENCES `ambiente` (`IDAmbiente`);

--
-- Limiti per la tabella `telefono`
--
ALTER TABLE `telefono`
  ADD CONSTRAINT `FKTelefono907515` FOREIGN KEY (`Utente`) REFERENCES `utente` (`CodiceFiscale`);

--
-- Limiti per la tabella `terzaparte`
--
ALTER TABLE `terzaparte`
  ADD CONSTRAINT `FKTerzaParte496589` FOREIGN KEY (`Utente`) REFERENCES `utente` (`CodiceFiscale`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `FKUtente772807` FOREIGN KEY (`Ruolo`) REFERENCES `ruolo` (`IDRuolo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

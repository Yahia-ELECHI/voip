-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 27 déc. 2019 à 19:27
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cdrcmr`
--

-- --------------------------------------------------------

--
-- Structure de la table `cdr`
--

CREATE TABLE `cdr` (
  `cdr_cdrRecordType` longtext DEFAULT NULL,
  `cdr_globalCallID_callManagerId` longtext DEFAULT NULL,
  `cdr_globalCallID_callId` longtext NOT NULL,
  `cdr_origLegCallIdentifier` longtext DEFAULT NULL,
  `cdr_dateTimeOrigination` datetime DEFAULT NULL,
  `cdr_origNodeId` longtext DEFAULT NULL,
  `cdr_origSpan` longtext DEFAULT NULL,
  `cdr_origIpAddr` longtext DEFAULT NULL,
  `cdr_callingPartyNumber` longtext DEFAULT NULL,
  `cdr_callingPartyUnicodeLoginUserID` longtext DEFAULT NULL,
  `cdr_origCause_location` longtext DEFAULT NULL,
  `cdr_origCause_value` longtext DEFAULT NULL,
  `cdr_origPrecedenceLevel` longtext DEFAULT NULL,
  `cdr_origMediaTransportAddress_IP` longtext DEFAULT NULL,
  `cdr_origMediaTransportAddress_Port` longtext DEFAULT NULL,
  `cdr_origMediaCap_payloadCapability` longtext DEFAULT NULL,
  `cdr_origMediaCap_maxFramesPerPacket` longtext DEFAULT NULL,
  `cdr_origMediaCap_g723BitRate` longtext DEFAULT NULL,
  `cdr_origVideoCap_Codec` longtext DEFAULT NULL,
  `cdr_origVideoCap_Bandwidth` longtext DEFAULT NULL,
  `cdr_origVideoCap_Resolution` longtext DEFAULT NULL,
  `cdr_origVideoTransportAddress_IP` longtext DEFAULT NULL,
  `cdr_origVideoTransportAddress_Port` longtext DEFAULT NULL,
  `cdr_origRSVPAudioStat` longtext DEFAULT NULL,
  `cdr_origRSVPVideoStat` longtext DEFAULT NULL,
  `cdr_destLegIdentifier` longtext DEFAULT NULL,
  `cdr_destNodeId` longtext DEFAULT NULL,
  `cdr_destSpan` longtext DEFAULT NULL,
  `cdr_destIpAddr` longtext DEFAULT NULL,
  `cdr_originalCalledPartyNumber` longtext DEFAULT NULL,
  `cdr_finalCalledPartyNumber` longtext DEFAULT NULL,
  `cdr_finalCalledPartyUnicodeLoginUserID` longtext DEFAULT NULL,
  `cdr_destCause_location` longtext DEFAULT NULL,
  `cdr_destCause_value` longtext DEFAULT NULL,
  `cdr_destPrecedenceLevel` longtext DEFAULT NULL,
  `cdr_destMediaTransportAddress_IP` longtext DEFAULT NULL,
  `cdr_destMediaTransportAddress_Port` longtext DEFAULT NULL,
  `cdr_destMediaCap_payloadCapability` longtext DEFAULT NULL,
  `cdr_destMediaCap_maxFramesPerPacket` longtext DEFAULT NULL,
  `cdr_destMediaCap_g723BitRate` longtext DEFAULT NULL,
  `cdr_destVideoCap_Codec` longtext DEFAULT NULL,
  `cdr_destVideoCap_Bandwidth` longtext DEFAULT NULL,
  `cdr_destVideoCap_Resolution` longtext DEFAULT NULL,
  `cdr_destVideoTransportAddress_IP` longtext DEFAULT NULL,
  `cdr_destVideoTransportAddress_Port` longtext DEFAULT NULL,
  `cdr_destRSVPAudioStat` longtext DEFAULT NULL,
  `cdr_destRSVPVideoStat` longtext DEFAULT NULL,
  `cdr_dateTimeConnect` longtext DEFAULT NULL,
  `cdr_dateTimeDisconnect` longtext DEFAULT NULL,
  `cdr_lastRedirectDn` longtext DEFAULT NULL,
  `cdr_pkid` longtext DEFAULT NULL,
  `cdr_originalCalledPartyNumberPartition` longtext DEFAULT NULL,
  `cdr_callingPartyNumberPartition` longtext DEFAULT NULL,
  `cdr_finalCalledPartyNumberPartition` longtext DEFAULT NULL,
  `cdr_lastRedirectDnPartition` longtext DEFAULT NULL,
  `cdr_duration` longtext DEFAULT NULL,
  `cdr_origDeviceName` longtext DEFAULT NULL,
  `cdr_destDeviceName` longtext DEFAULT NULL,
  `cdr_origCallTerminationOnBehalfOf` longtext DEFAULT NULL,
  `cdr_destCallTerminationOnBehalfOf` longtext DEFAULT NULL,
  `cdr_origCalledPartyRedirectOnBehalfOf` longtext DEFAULT NULL,
  `cdr_lastRedirectRedirectOnBehalfOf` longtext DEFAULT NULL,
  `cdr_origCalledPartyRedirectReason` longtext DEFAULT NULL,
  `cdr_lastRedirectRedirectReason` longtext DEFAULT NULL,
  `cdr_destConversationId` longtext DEFAULT NULL,
  `cdr_globalCallId_ClusterID` longtext DEFAULT NULL,
  `cdr_joinOnBehalfOf` longtext DEFAULT NULL,
  `cdr_comment` longtext DEFAULT NULL,
  `cdr_authCodeDescription` longtext DEFAULT NULL,
  `cdr_authorizationLevel` longtext DEFAULT NULL,
  `cdr_clientMatterCode` longtext DEFAULT NULL,
  `cdr_origDTMFMethod` longtext DEFAULT NULL,
  `cdr_destDTMFMethod` longtext DEFAULT NULL,
  `cdr_callSecuredStatus` longtext DEFAULT NULL,
  `cdr_origConversationId` longtext DEFAULT NULL,
  `cdr_origMediaCap_Bandwidth` longtext DEFAULT NULL,
  `cdr_destMediaCap_Bandwidth` longtext DEFAULT NULL,
  `cdr_authorizationCodeValue` longtext DEFAULT NULL,
  `cdr_outpulsedCallingPartyNumber` longtext DEFAULT NULL,
  `cdr_outpulsedCalledPartyNumber` longtext DEFAULT NULL,
  `cdr_origIpv4v6Addr` longtext DEFAULT NULL,
  `cdr_destIpv4v6Addr` longtext DEFAULT NULL,
  `cdr_origVideoCap_Codec_Channel2` longtext DEFAULT NULL,
  `cdr_origVideoCap_Bandwidth_Channel2` longtext DEFAULT NULL,
  `cdr_origVideoCap_Resolution_Channel2` longtext DEFAULT NULL,
  `cdr_origVideoTransportAddress_IP_Channel2` longtext DEFAULT NULL,
  `cdr_origVideoTransportAddress_Port_Channel2` longtext DEFAULT NULL,
  `cdr_origVideoChannel_Role_Channel2` longtext DEFAULT NULL,
  `cdr_destVideoCap_Codec_Channel2` longtext DEFAULT NULL,
  `cdr_destVideoCap_Bandwidth_Channel2` longtext DEFAULT NULL,
  `cdr_destVideoCap_Resolution_Channel2` longtext DEFAULT NULL,
  `cdr_destVideoTransportAddress_IP_Channel2` longtext DEFAULT NULL,
  `cdr_destVideoTransportAddress_Port_Channel2` longtext DEFAULT NULL,
  `cdr_destVideoChannel_Role_Channel2` longtext DEFAULT NULL,
  `cdr_incomingProtocolID` longtext DEFAULT NULL,
  `cdr_incomingProtocolCallRef` longtext DEFAULT NULL,
  `cdr_outgoingProtocolID` longtext DEFAULT NULL,
  `cdr_outgoingProtocolCallRef` longtext DEFAULT NULL,
  `cdr_currentRoutingReason` longtext DEFAULT NULL,
  `cdr_origRoutingReason` longtext DEFAULT NULL,
  `cdr_lastRedirectingRoutingReason` longtext DEFAULT NULL,
  `cdr_huntPilotDN` longtext DEFAULT NULL,
  `cdr_huntPilotPartition` longtext DEFAULT NULL,
  `cdr_calledPartyPatternUsage` longtext DEFAULT NULL,
  `cdr_outpulsedOriginalCalledPartyNumber` longtext DEFAULT NULL,
  `cdr_outpulsedLastRedirectingNumber` longtext DEFAULT NULL,
  `cdr_wasCallQueued` longtext DEFAULT NULL,
  `cdr_totalWaitTimeInQueue` longtext DEFAULT NULL,
  `cdr_callingPartyNumber_uri` longtext DEFAULT NULL,
  `cdr_originalCalledPartyNumber_uri` longtext DEFAULT NULL,
  `cdr_finalCalledPartyNumber_uri` longtext DEFAULT NULL,
  `cdr_lastRedirectDn_uri` longtext DEFAULT NULL,
  `cdr_mobileCallingPartyNumber` longtext DEFAULT NULL,
  `cdr_finalMobileCalledPartyNumber` longtext DEFAULT NULL,
  `cdr_origMobileDeviceName` longtext DEFAULT NULL,
  `cdr_destMobileDeviceName` longtext DEFAULT NULL,
  `cdr_origMobileCallDuration` longtext DEFAULT NULL,
  `cdr_destMobileCallDuration` longtext DEFAULT NULL,
  `cdr_mobileCallType` longtext DEFAULT NULL,
  `cdr_originalCalledPartyPattern` longtext DEFAULT NULL,
  `cdr_finalCalledPartyPattern` longtext DEFAULT NULL,
  `cdr_lastRedirectingPartyPattern` longtext DEFAULT NULL,
  `cdr_huntPilotPattern` longtext DEFAULT NULL,
  `cdr_ID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `cmr`
--

CREATE TABLE `cmr` (
  `cmr_cdrRecordType` longtext DEFAULT NULL,
  `cmr_globalCallID_callManagerId` longtext DEFAULT NULL,
  `cmr_globalCallID_callId` longtext DEFAULT NULL,
  `cmr_orignodeId` longtext DEFAULT NULL,
  `cmr_destnodeId` longtext DEFAULT NULL,
  `cmr_origlegcallIdentifier` longtext DEFAULT NULL,
  `cmr_destlegidentifier` longtext DEFAULT NULL,
  `cmr_orignumberPacketsSent` longtext DEFAULT NULL,
  `cmr_orignumberOctetsSent` longtext DEFAULT NULL,
  `cmr_orignumberPacketsReceived` longtext DEFAULT NULL,
  `cmr_orignumberOctetsReceived` longtext DEFAULT NULL,
  `cmr_orignumberPacketsLost` longtext DEFAULT NULL,
  `cmr_destnumberPacketsSent` longtext DEFAULT NULL,
  `cmr_destnumberOctetsSent` longtext DEFAULT NULL,
  `cmr_destnumberPacketsReceived` longtext DEFAULT NULL,
  `cmr_destnumberOctetsReceived` longtext DEFAULT NULL,
  `cmr_destnumberPacketsLost` longtext DEFAULT NULL,
  `cmr_origjitter` longtext DEFAULT NULL,
  `cmr_destjitter` longtext DEFAULT NULL,
  `cmr_origlatency` longtext DEFAULT NULL,
  `cmr_destlatency` longtext DEFAULT NULL,
  `cmr_pkid` longtext DEFAULT NULL,
  `cmr_origdeviceName` longtext DEFAULT NULL,
  `cmr_destdeviceName` longtext DEFAULT NULL,
  `cmr_origvarVQMetrics` varchar(20) NOT NULL DEFAULT 'NA',
  `cmr_destvarVQMetrics` varchar(20) NOT NULL DEFAULT 'NA',
  `cmr_globalCallId_ClusterID` longtext DEFAULT NULL,
  `cmr_callingPartyNumber` longtext DEFAULT NULL,
  `cmr_finalCalledPartyNumber` longtext DEFAULT NULL,
  `cmr_callingPartyNumberPartition` longtext DEFAULT NULL,
  `cmr_finalCalledPartyNumberPartition` longtext DEFAULT NULL,
  `cdr_ID_fk` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(4) NOT NULL,
  `LOGIN` varchar(100) NOT NULL,
  `PWD` varchar(255) NOT NULL,
  `ROLE` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `ETAT` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `LOGIN`, `PWD`, `ROLE`, `EMAIL`, `ETAT`) VALUES
(1, 'admin', '1344b80e5882cb70bc04adb1bbc243e8', 'ADMIN', 'echiyahya@live.fr', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cdr`
--
ALTER TABLE `cdr`
  ADD PRIMARY KEY (`cdr_ID`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cdr`
--
ALTER TABLE `cdr`
  MODIFY `cdr_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

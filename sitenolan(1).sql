-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 12 Mai 2015 à 13:28
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `sitenolan`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `resume` varchar(1000) NOT NULL,
  `derniere_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contenu` text NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id`, `user_id`, `titre`, `resume`, `derniere_date`, `contenu`, `image`) VALUES
(40, 1, 'Biographie de Christopher Nolan', 'Christopher Nolan, né le 30 juillet 1970 à Londres, est un réalisateur, producteur et scénariste britanno-américain. Il s''est fait connaître à la fin des années 1990 grâce à son premier long métrage Following, tourné en noir et blanc. Par la suite, il a connu le succès avec les films Memento, Le Prestige, Inception, Interstellar et la plus récente série de films Batman : Batman Begins, The Dark Knight et The Dark Knight Rises.\r\n\r\nIl est principalement connu pour ses scénarios complexes, et il a traité de nombreux sujets à travers ces films comme la mémoire pour Memento, la magie pour Le Prestige, les rêves pour Inception et l''espace et le temps dans Interstellar. Il est le PDG et créateur de la société de production Syncopy Films.', '2015-05-12 00:23:54', 'Les débuts\r\n\r\nChristopher Nolan est un cinéaste primé qui a été reconnu pour son travail en tant que réalisateur, scénariste et producteur. Né à Londres, Nolan a commencé à faire des films à un âge précoce avec la caméra Super-8mm de son père. Pendant ses études de littérature anglaise au College University de Londres, il a tourné des films 16mm à la société de film de l''UCL, où il a appris les techniques des films de guerre qu''il utilisera plus tard pour faire son premier long métrage, The Following. Ce thriller noir a été reconnu à un certain nombre de festivals internationaux avant sa sortie en salles.\r\nLe début du succès\r\n\r\nLe deuxième film de Nolan a été le film indépendant Memento, qu''il a dirigé à partir de son propre scénario, basé sur une nouvelle de son frère Jonathan. Avec Guy Pearce, le film a fait remporter à Nolan de nombreux prix, dont l''Oscar et le Golden Globe Award du meilleur scénario original, l''Independent Spirit Awards du meilleur réalisateur et du meilleur scénario, et une nomination au Directors Guild of America (DGA) Award. Nolan a continué à diriger le thriller psychologique acclamé par la critique, Insomnia, mettant en vedette les Oscarisés Al Pacino, Robin Williams, et Hilary Swank.\r\nDe Batman à Interstellar\r\n\r\nEn 2005, Nolan a co-écrit et réalisé Batman Begins, avec Christian Bale, Michael Caine, Liam Neeson, Gary Oldman et Morgan Freeman. Salué par la critique et le public, le film de Nolan re-imaginé les films classiques de Batman et a fait de lui un héros emblématique et pertinent pour notre époque. En 2008, Nolan a dirigé, co-écrit et produit The Dark Knight, qui a gagné plus d''un milliard de dollars au box-office mondial et a été acclamé par la critique internationale. Nolan a été nominé pour un Directors Guild of America (DGA) Award, un Writers Guild of America (WGA) Award, et un Producers Guild of America (PGA) Award. Le film a également reçu huit nominations aux Oscars.\r\n\r\nNolan a dirigé, co-écrit et produit un thriller en 2006. Le Prestige est joué par Christian Bale et Hugh Jackman, magiciens dont la rivalité obsessionnelle conduit à la tragédie et à l''assassinat. Le film a reçu des nominations aux Oscars pour sa direction artistique et cinématographique exceptionnelle.\r\n\r\nEn 2010, Nolan séduit le public avec le film de science-fiction Inception acclamé, qu''il a dirigé et produit à partir de son propre scénario original. Ce drame de réflexion était une superproduction mondiale, gagnant plus de 800 millions de dollars et devenant l''un des films les plus discutés et débattus de l''année. Parmi ses nombreuses distinctions, Inception a reçu quatre Oscars et huit nominations, dont celui du meilleur film et du meilleur scénario. Nolan a été reconnu par ses pairs avec la DGA et le PGA Award nominations, ainsi que le Prix WGA pour son travail sur le film.\r\n\r\nL''an dernier, Nolan conclut sa trilogie des films sur Batman avec The Dark Knight Rises. Comme son prédécesseur, il s''est très bien vendu au box-office, gagnant plus d''un milliard de dollars dans le monde entier. Seuls trois réalisateurs ont atteint cette étape avec deux films distincts: James Cameron, Peter Jackson, et Christopher Nolan. Il a également marqué la dernière collaboration entre Christopher Nolan et le directeur de la photographie Wally Pfister, qui a récemment lancé sa propre carrière de réalisateur.\r\n\r\nEn 2013, Christopher Nolan a produit Man of Steel, réalisé par Zack Snyder. Ce fut la première fois que Nolan produit un film sans le réaliser.\r\n\r\nL''année dernière, Christopher Nolan a co-écrit, réalisé et produit son 9ème long métrage, Interstellar. Il a mis en vedette Matthew McConaughey, Anne Hathaway, Jessica Chastain, et Michael Caine.\r\nVie Privée\r\n\r\nNolan réside à Los Angeles avec sa femme, la productrice Emma Thomas, et leurs enfants. Nolan et Thomas dirigent aussi leur propre société de production, Syncopy.', 'data/Christopher_nolan_20150512002354.jpg'),
(41, 1, 'Critique d''Interstellar', 'Interstellar utilise la même main courante dont les films de l''espace ont profité. Distiller les craintes et les rêves les plus farfelus de leur époque et en faire un miroir de l''humeur peuplant chaque esprit connaissant la définition de l''intellectualisme, tout en prenant bien soin de citer les tendances scientifiques et astronomiques du moment.', '2015-05-12 01:07:36', '2001 l''Odyssée de l''espace a mélangé les promesses et les menaces de l''ère Apollo et les a enduites du criticisme New Age d''une culture de plus en plus cynique et goinfre de distraction et de confort. Star Wars s''est fixé l''objectif de rassasier une culture commençant à s''ennuyer de son oisiveté et de sa docilité affligeantes en se baignant dans un patriotisme héroïque naissant chez les anciennes colonies. Interstellar s''est dégoté un sujet apocalyptique &quot;indie&quot; (étant donné que les pandémies et les guerres mondiales constituent le terrain spéculatif des kékés intellectuels et autres formes de &quot;beaufferie&quot; intelligentsia), et a bien révisé les théories les plus répandues dans le domaine de l''astronomie et de la physique quantique, mais a surtout veillé à réussir l''esthétisme minimaliste très soigné qui a assuré l''éloge et la gloire de chaque oeuvre artistique de ces deux dernières décennies.\r\n\r\nLes fins gourmets des intrigues et retournements de situations trouveront bien leur compte. A une heure du film, ils s''entassent même pêle-mêle et s''arrachent l''attention du spectateur, mais la volonté de Christopher et Jonathan Nolan à aborder plusieurs sujets et fils narratifs en fait plus un déballage d''astuces apprises au cours de leurs films (Notamment Memento et Inception) qu''une véritable première en matière de suspense et d''immersion. Une violente bataille dans laquelle la dimension personnelle et émotionnelle des personnages s''en trouve perdante. Les vaines tentatives d''accélérer l''attachement aux sorts de ces malheureux deviennent plus agaçante qu''autre chose. Qui accorderait de sa concentration à une histoire d''amour entre deux scientifiques quand il est question d''utiliser un trou noir pour manier le temps ?\r\n\r\nLes désastres et les mauvaises nouvelles prennent un temps fou pour devenir clairs avant de se défaire rapidement d''un coup de balai en forme de gribouillis scientifiques calculé avec la même aisance et rapidité qu''une addition d''un dîner à deux, ou une récitation robotique des conclusions cultes des documentaires scientifiques les plus réussis. A certaines instances, on est pris de pitié pour les acteurs qui se trouvent au bout d''un bazar bâclé étonnamment plus consistant que la durée déjà olympique du film. Ceci n''est pourtant pas ce qui devrait dégoûter le spectateur, ce qui devrait rendre l''opinion de ce film moins clémente est le recours du tour de maître, néanmoins instantanément épuisé, d''Inception. Est-ce que le dernier tiers du film est un fantasme désespéré ou une réalité gratifiante. Cela a marché pour Inception et a contribué à rendre le film excellent, mais il était bien trop tôt de répéter le même coup sans laisser la mauvaise foi, suggérant une paresse ou une cupidité quelconque, s''exprimer.\r\n\r\nToutefois, les frères Nolan ont très bien réussi à confondre le négationnisme scientifique et la technophobie. Bien que l''un est censé être en conflit avec l''autre, les grands noms de la science théorique (Stephen Hawking) et pratique (Bill Gates) finissent toujours par faire le même Post-scriptum : aduler aveuglément la science conduirait aux mêmes ravages qu''aduler toute autre gymnastique de l''esprit humain. Avec le même chic qui leur est propre, ils ont souligné qu''une fois qu''une société s''habitue à son cataclysme, elle se met à rechercher des solutions myopes lui permettant de vivre au jour le jour, conduisant à un cynisme défaitiste, au lieu de prendre sur elle-même et tenter le tout pour le tout.\r\n\r\nLe talent de Nolan de ne pas s''encombrer des moyens habituels de faire plonger le spectateur dans une histoire complètement imaginaire est toujours au rendez-vous. Les personnages vivent leur horrible quotidien de manière très ordinaire et l''assurance de leur jeu réussit à rendre leurs dilemmes crédibles. Les détails visuels sont irréprochables et l''élégance de leur apparition à l''écran suffit à gérer toute forme d''ennui due au manque de constistance régnant sur la deuxième moitié du film.\r\n\r\nQuant à la science abordée, je trouve qu''il est inutile de la décortiquer étant donné que l''humanité ne s''est jamais aventurée plus loin que la face illuminée de la lune. Et le fait que Degrasse Tyson, entre autres, s''est déclaré grand défenseur des théories utilisées par le film enlève toute crédibilité aux dires de tout autre personne qu''un Bac + 1000.\r\n\r\nEn tout et pour tout, Interstellar aurait été mieux accepté s''il avait été réalisé par un autre que Christopher Nolan, mais il l''aurait été beaucoup moins s''il était sorti avant Gravity. La rudesse du visuel enrobé de la complexité des évènements place le film d''Alfonso Cuarón au rang d''Elysium et autres &quot;lolleries&quot; sci-fi. Le jeu des acteurs, qui n''ont plus rien à prouver à qui que ce soit (notamment un certain que je ne mentionnerais pas) contribuent grandement à la beauté du génie des effets spéciaux propre au réalisateur. ', 'data/station_spatiale_20150512010736.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_article` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `user_id`, `article_id`, `contenu`, `date`) VALUES
(3, 1, 40, 'J\\''espère que ce site vous plaira, merci pour votre attention :)', '2015-05-12 00:52:02'),
(9, 6, 40, 'J\\''adore ce réalisateur, je le suis depuis ses débuts, merci pour ce blog !', '2015-05-12 01:04:29'),
(10, 5, 40, 'Salut Armays c\\''est un bon début continue comme ça.', '2015-05-12 01:05:38'),
(11, 1, 41, 'Merci beaucoup à Pinkasblack pour cet excellent article !', '2015-05-12 01:07:57');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `nom`, `date_inscription`, `type`) VALUES
(1, 'admin', 'admin', 'Administrateur', '2015-05-05 20:00:00', 1),
(2, 'mateusz', 'mateusz', 'Mateusz', '2015-05-09 15:29:42', 0),
(5, 'ephe', 'ephe', 'Ephe', '2015-05-12 00:52:41', 0),
(6, 'nolan-addict', 'nolan-addict', 'Nolan-addict', '2015-05-12 00:53:12', 0);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_user2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

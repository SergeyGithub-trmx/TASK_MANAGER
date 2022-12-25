INSERT INTO `user` (login, email, password_hash) VALUES
('SergHecker', 'trojan.win32.serGEEi@mail.ru', 'As.[#_,LG?6*EC]M^]n-'),
('AUGMENTARO', 'microsoft.myspecacc@outlook.com', ']Rt&7dzl+N^6<5r)OcYV'),
('mylifebelikeooayauu', 'den.500thousands-consolelogs@hotmail.com', '_?&B\:\1.R1TX%&x/_Ue'),
('TheGrogy', 'gorbunek@gmail.com', '4$6./w0Gr75Mb61_0-1!'),
('IgorKLhacker', 'idontknow@inbox.ru', '+]2\?.74Gb&jK0-=27Hs');

INSERT INTO `project` (name, user_id) VALUES
('Everyday doings', 1),
('Hacking with Backdoor', 2),
('HTML-virus with Exploit', 3),
('First CTF-Pentesting', 4),
('Install KALI and msfconsole', 5);

INSERT INTO `task` (name, user_id, project_id) VALUES
('Shopping', 1, 1),
('Prank friend with Exploit', 2, 2),
('Upload my new HTML-virus', 3, 3),
('Install RMS', 4, 4),
('Try old ms17-010-eternalblue', 5, 5);
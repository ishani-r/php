DELIMITER $$

CREATE
    /*[DEFINER = { user | CURRENT_USER }]*/
    TRIGGER `smart bike`.`facultytype` AFTER DELETE
    ON `smart bike`.`faculty`
    FOR EACH ROW BEGIN
		DELETE FROM faculty_type WHERE NAME=old.name
    END$$

DELIMITER ;
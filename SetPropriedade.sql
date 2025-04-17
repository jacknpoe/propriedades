DELIMITER //

CREATE OR REPLACE PROCEDURE SetPropriedade(chave VARCHAR(30), valor VARCHAR(500))

BEGIN
	START TRANSACTION;
	SELECT @total := COUNT(*) FROM propriedade WHERE UPPER(NM_CHAVE) = UPPER(chave);
	IF @total < 1 THEN
		INSERT INTO propriedade (NM_CHAVE, NM_VALOR) VALUES (UPPER(chave), valor);
	ELSE
		UPDATE propriedade SET NM_VALOR = valor WHERE UPPER(NM_CHAVE) = UPPER(chave);	
	END IF;
	COMMIT;
END //

DELIMITER ;

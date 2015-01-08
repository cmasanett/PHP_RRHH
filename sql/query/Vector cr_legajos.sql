-- ----------------------------
-- Vector cr_legajos, cr_empre
-- ----------------------------

SELECT 
    l.*,
	IF(COALESCE(NULL, p.valor, 'xxx') + IF(UPPER(TRIM(e.comparacion)) = 'EN',
            ' IN (' + e.valor_dato_baja + ')',
            e.comparacion + e.valor_dato_baja),
        'I',
        ' ') AS inactivo,
	e.dato_legajo_baja,
	e.comparacion,
    e.valor_dato_baja
FROM
    zend_php_demo.n7_legajos l
        LEFT JOIN
    zend_php_demo.n7_empresas e ON e.id = l.empresa_id
        LEFT JOIN
    zend_php_demo.n7_ppd_l p ON p.objeto_id = l.id
        AND p.propiedad_id = e.dato_legajo_baja
WHERE
    empresa_id = 1
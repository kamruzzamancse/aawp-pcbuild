<?php


                    function normalize_color($value) {
                        $value = trim(strtolower($value));

                        // Known valid colors (you can expand this list)
                        $colors = [
                            'black', 'white', 'blue', 'red', 'gold', 'green', 'yellow',
                            'silver', 'grey', 'gray', 'orange', 'pink', 'purple', 'multicolor', 'multicolored', 'deep black', 'matte black'
                        ];

                        // Separate with commas, semicolons, or dashes
                        $parts = preg_split('/[\s,\-;\/]+/', $value);
                        $matched_colors = [];

                        foreach ($parts as $part) {
                            $part = trim($part);
                            if (in_array($part, $colors)) {
                                $matched_colors[] = ucwords($part);
                            }
                        }

                        if (!empty($matched_colors)) {
                            return implode(' / ', array_unique($matched_colors));
                        }

                        return '—'; // fallback if no match
                    }
?>
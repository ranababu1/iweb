<?php
namespace Site_AI_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Local, deterministic AI-slop heuristics for post content.
 *
 * No model calls and no outbound requests. Scores are review signals,
 * not proof of AI authorship.
 */
final class Slop {

	const WEIGHT_STRONG = 3;
	const WEIGHT_MEDIUM = 2;
	const WEIGHT_WEAK   = 1;

	const PHRASES = array(
		// Strong indicators.
		'delve into'                    => self::WEIGHT_STRONG,
		'delves into'                   => self::WEIGHT_STRONG,
		'delving into'                  => self::WEIGHT_STRONG,
		'delve deeper'                  => self::WEIGHT_STRONG,
		'rich tapestry'                 => self::WEIGHT_STRONG,
		'tapestry of'                   => self::WEIGHT_STRONG,
		'ever-evolving'                 => self::WEIGHT_STRONG,
		'ever-changing'                 => self::WEIGHT_STRONG,
		'ever-growing'                  => self::WEIGHT_STRONG,
		'embark on a journey'           => self::WEIGHT_STRONG,
		'embarking on a journey'        => self::WEIGHT_STRONG,
		'testament to'                  => self::WEIGHT_STRONG,
		'stands as a testament'         => self::WEIGHT_STRONG,
		'treasure trove'                => self::WEIGHT_STRONG,
		'unlock the power of'           => self::WEIGHT_STRONG,
		'harness the power of'          => self::WEIGHT_STRONG,
		'unleash the power of'          => self::WEIGHT_STRONG,
		'in the realm of'               => self::WEIGHT_STRONG,
		'paradigm shift'                => self::WEIGHT_STRONG,
		'revolutionize the way'         => self::WEIGHT_STRONG,
		'revolutionizing the way'       => self::WEIGHT_STRONG,
		'navigate the complexities'     => self::WEIGHT_STRONG,
		'navigating the complexities'   => self::WEIGHT_STRONG,
		'navigate the landscape'        => self::WEIGHT_STRONG,
		'navigating the landscape'      => self::WEIGHT_STRONG,
		'in today\'s fast-paced world'  => self::WEIGHT_STRONG,
		'fear not'                      => self::WEIGHT_STRONG,
		'without further ado'           => self::WEIGHT_STRONG,
		'buckle up'                     => self::WEIGHT_STRONG,
		'look no further'               => self::WEIGHT_STRONG,
		'whether you\'re a'             => self::WEIGHT_STRONG,
		'underscores the importance'    => self::WEIGHT_STRONG,
		'game-changer'                  => self::WEIGHT_STRONG,
		'seamless integration'          => self::WEIGHT_STRONG,
		'seamless experience'           => self::WEIGHT_STRONG,
		'in the digital age'            => self::WEIGHT_STRONG,
		'at its core'                   => self::WEIGHT_STRONG,
		'myriad of'                     => self::WEIGHT_STRONG,
		'plethora of'                   => self::WEIGHT_STRONG,
		'deep dive into'                => self::WEIGHT_STRONG,
		'dive deep into'               => self::WEIGHT_STRONG,
		'as an ai'                      => self::WEIGHT_STRONG,
		'language model'                => self::WEIGHT_STRONG,
		'the possibilities are endless' => self::WEIGHT_STRONG,
		'in the grand scheme of things' => self::WEIGHT_STRONG,
		// Medium indicators.
		'delve'                          => self::WEIGHT_MEDIUM,
		'delves'                         => self::WEIGHT_MEDIUM,
		'delving'                        => self::WEIGHT_MEDIUM,
		'tapestry'                       => self::WEIGHT_MEDIUM,
		'game changer'                   => self::WEIGHT_MEDIUM,
		'embark on'                      => self::WEIGHT_MEDIUM,
		'in conclusion'                  => self::WEIGHT_MEDIUM,
		'in summary'                     => self::WEIGHT_MEDIUM,
		'to sum up'                      => self::WEIGHT_MEDIUM,
		'in closing'                     => self::WEIGHT_MEDIUM,
		'to conclude'                    => self::WEIGHT_MEDIUM,
		'it is important to note'        => self::WEIGHT_MEDIUM,
		'it\'s important to note'       => self::WEIGHT_MEDIUM,
		'it is worth noting'             => self::WEIGHT_MEDIUM,
		'it\'s worth noting'            => self::WEIGHT_MEDIUM,
		'it should be noted'             => self::WEIGHT_MEDIUM,
		'keep in mind that'              => self::WEIGHT_MEDIUM,
		'remember that'                  => self::WEIGHT_MEDIUM,
		'crucial role'                   => self::WEIGHT_MEDIUM,
		'pivotal role'                   => self::WEIGHT_MEDIUM,
		'plays a vital role'             => self::WEIGHT_MEDIUM,
		'double-edged sword'             => self::WEIGHT_MEDIUM,
		'at the end of the day'          => self::WEIGHT_MEDIUM,
		'key takeaway'                   => self::WEIGHT_MEDIUM,
		'key takeaways'                  => self::WEIGHT_MEDIUM,
		'let\'s explore'                 => self::WEIGHT_MEDIUM,
		'let us explore'                 => self::WEIGHT_MEDIUM,
		'let\'s dive in'                 => self::WEIGHT_MEDIUM,
		'let\'s take a look'            => self::WEIGHT_MEDIUM,
		'comprehensive guide'            => self::WEIGHT_MEDIUM,
		'everything you need to know'    => self::WEIGHT_MEDIUM,
		'in essence'                     => self::WEIGHT_MEDIUM,
		'in a nutshell'                  => self::WEIGHT_MEDIUM,
		'long story short'               => self::WEIGHT_MEDIUM,
		'the bottom line'                => self::WEIGHT_MEDIUM,
		'a symphony of'                  => self::WEIGHT_MEDIUM,
		'supercharge your'               => self::WEIGHT_MEDIUM,
		'elevate your'                   => self::WEIGHT_MEDIUM,
		'take it to the next level'      => self::WEIGHT_MEDIUM,
		'first and foremost'             => self::WEIGHT_MEDIUM,
		'last but not least'             => self::WEIGHT_MEDIUM,
		'in today\'s world'              => self::WEIGHT_MEDIUM,
		'rapidly evolving'               => self::WEIGHT_MEDIUM,
		'fast-paced world'               => self::WEIGHT_MEDIUM,
		'navigate the world of'         => self::WEIGHT_MEDIUM,
		'navigating the world of'       => self::WEIGHT_MEDIUM,
		'cutting-edge'                   => self::WEIGHT_MEDIUM,
		'cutting edge'                   => self::WEIGHT_MEDIUM,
		'beacon of'                      => self::WEIGHT_MEDIUM,
		'pave the way'                   => self::WEIGHT_MEDIUM,
		'tip of the iceberg'             => self::WEIGHT_MEDIUM,
		'demystify'                      => self::WEIGHT_MEDIUM,
		'demystifying'                   => self::WEIGHT_MEDIUM,
		'fostering a sense of'           => self::WEIGHT_MEDIUM,
		'master the art of'             => self::WEIGHT_MEDIUM,
		// Weak indicators.
		'furthermore'                    => self::WEIGHT_WEAK,
		'moreover'                       => self::WEIGHT_WEAK,
		'additionally'                   => self::WEIGHT_WEAK,
		'in addition'                    => self::WEIGHT_WEAK,
		'ultimately'                     => self::WEIGHT_WEAK,
		'essentially'                    => self::WEIGHT_WEAK,
		'firstly'                        => self::WEIGHT_WEAK,
		'secondly'                       => self::WEIGHT_WEAK,
		'thirdly'                        => self::WEIGHT_WEAK,
		'lastly'                         => self::WEIGHT_WEAK,
		'robust'                         => self::WEIGHT_WEAK,
		'seamless'                       => self::WEIGHT_WEAK,
		'seamlessly'                     => self::WEIGHT_WEAK,
		'leverage'                       => self::WEIGHT_WEAK,
		'leveraging'                     => self::WEIGHT_WEAK,
		'unlock'                         => self::WEIGHT_WEAK,
		'unleash'                        => self::WEIGHT_WEAK,
		'innovative'                     => self::WEIGHT_WEAK,
		'dive into'                      => self::WEIGHT_WEAK,
		'deep dive'                      => self::WEIGHT_WEAK,
		'vibrant'                        => self::WEIGHT_WEAK,
		'dynamic'                        => self::WEIGHT_WEAK,
		'nuanced'                        => self::WEIGHT_WEAK,
		'intricate'                      => self::WEIGHT_WEAK,
		'meticulous'                     => self::WEIGHT_WEAK,
		'meticulously'                   => self::WEIGHT_WEAK,
		'utilize'                        => self::WEIGHT_WEAK,
		'utilizing'                      => self::WEIGHT_WEAK,
		'underscores'                    => self::WEIGHT_WEAK,
		'pivotal'                        => self::WEIGHT_WEAK,
		'crucial'                        => self::WEIGHT_WEAK,
		'paramount'                      => self::WEIGHT_WEAK,
		'realm'                          => self::WEIGHT_WEAK,
		'harness'                        => self::WEIGHT_WEAK,
		'transformative'                 => self::WEIGHT_WEAK,
		'revolutionary'                  => self::WEIGHT_WEAK,
		'groundbreaking'                 => self::WEIGHT_WEAK,
		'unparalleled'                   => self::WEIGHT_WEAK,
		'navigate'                       => self::WEIGHT_WEAK,
		'navigating'                     => self::WEIGHT_WEAK,
		'landscape of'                   => self::WEIGHT_WEAK,
		'the world of'                   => self::WEIGHT_WEAK,
		'when it comes to'               => self::WEIGHT_WEAK,
		'on the other hand'              => self::WEIGHT_WEAK,
		'not to mention'                 => self::WEIGHT_WEAK,
		'foster'                         => self::WEIGHT_WEAK,
		'fostering'                      => self::WEIGHT_WEAK,
		'beauty of'                      => self::WEIGHT_WEAK,
		'unpack'                         => self::WEIGHT_WEAK,
		'shed light on'                  => self::WEIGHT_WEAK,
		'needless to say'                => self::WEIGHT_WEAK,
		'holistic'                       => self::WEIGHT_WEAK,
	);

	public static function detect( array $input ) {
		$selection = Content::select_posts( $input, 10, 100 );
		if ( is_wp_error( $selection ) ) {
			return $selection;
		}

		$min_score = min( 100, max( 0, absint( $input['min_score'] ?? 0 ) ) );
		$details   = ! empty( $input['include_details'] );

		$pattern = self::phrase_pattern();

		$posts     = array();
		$scanned   = 0;
		$score_sum = 0;
		$summary   = array(
			'high'     => 0,
			'likely'   => 0,
			'possible' => 0,
			'low'      => 0,
		);

		foreach ( $selection['posts'] as $post ) {
			if ( ! $post instanceof \WP_Post ) {
				continue;
			}

			if ( ! current_user_can( 'read_post', $post->ID ) ) {
				continue;
			}

			$analysis = self::analyze( $post->post_content, $pattern );
			$scanned++;
			$score_sum += $analysis['score'];
			$summary[ $analysis['verdict'] ]++;

			if ( $analysis['score'] < $min_score ) {
				continue;
			}

			$entry = array(
				'post_id'    => (int) $post->ID,
				'title'      => get_the_title( $post ),
				'url'        => get_permalink( $post ),
				'status'     => $post->post_status,
				'word_count' => $analysis['word_count'],
				'score'      => $analysis['score'],
				'verdict'    => $analysis['verdict'],
				'signals'    => $analysis['signals'],
				'matches'    => $details ? $analysis['matches'] : array_slice( $analysis['matches'], 0, 8 ),
			);

			if ( $details ) {
				$entry['metrics'] = $analysis['metrics'];
			}

			$posts[] = $entry;
		}

		return array(
			'success'       => true,
			'posts_scanned' => $scanned,
			'returned'      => count( $posts ),
			'min_score'     => $min_score,
			'average_score' => $scanned > 0 ? round( $score_sum / $scanned, 1 ) : 0,
			'summary'       => $summary,
			'note'          => 'Deterministic local heuristics. A score is a review signal, not proof of AI authorship.',
			'posts'         => $posts,
		);
	}

	private static function phrase_pattern(): string {
		static $pattern = null;

		if ( null === $pattern ) {
			$phrases = array_map( 'strtolower', array_keys( self::PHRASES ) );
			usort(
				$phrases,
				static function ( $a, $b ) {
					return strlen( $b ) - strlen( $a );
				}
			);

			$alternation = array_map(
				static function ( $phrase ) {
					return preg_quote( $phrase, '/' );
				},
				$phrases
			);

			$pattern = '/(?<![\p{L}\p{N}])(?:' . implode( '|', $alternation ) . ')(?![\p{L}\p{N}])/ui';
		}

		return $pattern;
	}
	private static function analyze( string $html, string $pattern ): array {
		$text = self::normalize( wp_strip_all_tags( $html ) );

		$word_list = preg_split( '/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY );
		if ( ! is_array( $word_list ) ) {
			$word_list = array();
		}
		$words = count( $word_list );

		if ( $words < 50 ) {
			return array(
				'word_count' => $words,
				'score'      => 0,
				'verdict'    => 'low',
				'signals'    => array( 'Too little text for a meaningful AI-slop analysis.' ),
				'matches'    => array(),
				'metrics'    => array(),
			);
		}

		$per_thousand = 1000 / $words;

		$counts       = array();
		$first_offset = array();
		$found        = array();

		if ( preg_match_all( $pattern, $text, $found, PREG_OFFSET_CAPTURE ) ) {
			foreach ( $found[0] as $hit ) {
				$key = strtolower( (string) $hit[0] );
				if ( ! isset( $counts[ $key ] ) ) {
					$counts[ $key ]       = 0;
					$first_offset[ $key ] = (int) $hit[1];
				}
				$counts[ $key ]++;
			}
		}

		$weighted = 0;
		$matches  = array();

		foreach ( $counts as $phrase => $count ) {
			$weight    = isset( self::PHRASES[ $phrase ] ) ? self::PHRASES[ $phrase ] : self::WEIGHT_WEAK;
			$weighted += $count * $weight;
			$matches[] = array(
				'phrase' => $phrase,
				'count'  => $count,
				'weight' => $weight,
				'sample' => self::excerpt( $text, $first_offset[ $phrase ] ),
			);
		}

		usort(
			$matches,
			static function ( $a, $b ) {
				return ( $b['count'] * $b['weight'] ) <=> ( $a['count'] * $a['weight'] );
			}
		);

		$phrase_density = $weighted * $per_thousand;

		$em_dash         = preg_match_all( '/\x{2014}/u', $text );
		$em_dash         = is_int( $em_dash ) ? $em_dash : 0;
		$em_dash_density = $em_dash * $per_thousand;

		$sentences = preg_split( '/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY );
		$sentences = is_array( $sentences ) ? $sentences : array();

		$transition_single = array( 'furthermore', 'moreover', 'additionally', 'also', 'however', 'therefore', 'thus', 'consequently', 'firstly', 'secondly', 'thirdly', 'finally', 'lastly', 'ultimately', 'nonetheless', 'nevertheless', 'overall', 'essentially' );
		$transition_multi  = array( 'in addition', 'in conclusion', 'in summary', 'in essence', 'in closing', 'in other words', 'that being said', 'on the other hand' );

		$sentence_lengths  = array();
		$starter_counts   = array();
		$transition_count = 0;

		foreach ( $sentences as $sentence ) {
			$parts = preg_split( '/\s+/u', trim( $sentence ), -1, PREG_SPLIT_NO_EMPTY );
			if ( ! is_array( $parts ) || empty( $parts ) ) {
				continue;
			}

			$sentence_lengths[] = count( $parts );

			$first = strtolower( (string) preg_replace( '/[^\p{L}\p{N}]/u', '', (string) $parts[0] ) );
			if ( '' === $first ) {
				continue;
			}

			$starter_counts[ $first ] = ( $starter_counts[ $first ] ?? 0 ) + 1;

			$is_transition = in_array( $first, $transition_single, true );

			if ( ! $is_transition && isset( $parts[1] ) ) {
				$second = strtolower( (string) preg_replace( '/[^\p{L}\p{N}]/u', '', (string) $parts[1] ) );
				$is_transition = in_array( $first . ' ' . $second, $transition_multi, true );
			}

			if ( $is_transition ) {
				$transition_count++;
			}
		}

		$sentence_count = count( $sentence_lengths );

		$mean    = $sentence_count > 0 ? array_sum( $sentence_lengths ) / $sentence_count : 0;
		$variance = 0;

		if ( $mean > 0 ) {
			foreach ( $sentence_lengths as $length ) {
				$variance += ( $length - $mean ) ** 2;
			}
			$variance /= $sentence_count;
		}

		$cv = $mean > 0 ? sqrt( $variance ) / $mean : 1;

		$transition_ratio = $sentence_count > 0 ? $transition_count / $sentence_count : 0;

		$repeated_ratio = 0;
		$repeated_word  = '';

		if ( $sentence_count >= 10 ) {
			foreach ( $starter_counts as $word => $count ) {
				if ( $count / $sentence_count > $repeated_ratio ) {
					$repeated_ratio = $count / $sentence_count;
					$repeated_word  = $word;
				}
			}
		}

		$triads        = preg_match_all( '/[\p{L}\p{N}]+(?:\s+[\p{L}\p{N}]+)*,\s*[\p{L}\p{N}]+(?:\s+[\p{L}\p{N}]+)*,\s*(?:and|or)\s+[\p{L}\p{N}]+/u', $text );
		$triads        = is_int( $triads ) ? $triads : 0;
		$triad_density = $triads * $per_thousand;

		$tokens = array();
		foreach ( $word_list as $word ) {
			$clean = preg_replace( '/^[^\p{L}\p{N}]+|[^\p{L}\p{N}]+$/u', '', (string) $word );
			if ( null !== $clean && preg_match( '/^[\p{L}\p{N}\'-]{3,}$/u', $clean ) ) {
				$tokens[] = strtolower( $clean );
			}
		}

		$ttr = count( array_unique( $tokens ) ) / max( 1, count( $tokens ) );
		$score   = 0;
		$signals = array();

		$phrase_points = 0;

		if ( $phrase_density >= 15 ) {
			$phrase_points = 48;
		} elseif ( $phrase_density >= 10 ) {
			$phrase_points = 40;
		} elseif ( $phrase_density >= 7 ) {
			$phrase_points = 30;
		} elseif ( $phrase_density >= 4 ) {
			$phrase_points = 20;
		} elseif ( $phrase_density >= 2 ) {
			$phrase_points = 10;
		} elseif ( $phrase_density >= 0.5 ) {
			$phrase_points = 5;
		}

		$score += $phrase_points;

		if ( $phrase_points >= 20 ) {
			$signals[] = sprintf( 'High AI-cliche phrase density (%.1f weighted matches per 1000 words).', $phrase_density );
		} elseif ( $phrase_points > 0 ) {
			$signals[] = sprintf( 'Some AI-cliche phrasing detected (%.1f weighted matches per 1000 words).', $phrase_density );
		}

		if ( $sentence_count >= 10 ) {
			$uniform_points = 0;

			if ( $cv <= 0.25 ) {
				$uniform_points = 8;
			} elseif ( $cv <= 0.35 ) {
				$uniform_points = 4;
			}

			$score += $uniform_points;

			if ( $uniform_points > 0 ) {
				$signals[] = sprintf( 'Unusually uniform sentence lengths (variation coefficient %.2f).', $cv );
			}
		}

		$transition_points = 0;

		if ( $transition_ratio >= 0.2 ) {
			$transition_points = 8;
		} elseif ( $transition_ratio >= 0.12 ) {
			$transition_points = 4;
		}

		$score += $transition_points;

		if ( $transition_points > 0 ) {
			$signals[] = sprintf( '%d%% of sentences start with stock transition words.', (int) round( $transition_ratio * 100 ) );
		}

		if ( $repeated_ratio >= 0.25 ) {
			$score += 6;
			$signals[] = sprintf( '%d%% of sentences start with the same word ("%s").', (int) round( $repeated_ratio * 100 ), $repeated_word );
		}

		$dash_points = 0;

		if ( $em_dash_density >= 12 ) {
			$dash_points = 8;
		} elseif ( $em_dash_density >= 8 ) {
			$dash_points = 5;
		} elseif ( $em_dash_density >= 5 ) {
			$dash_points = 3;
		}

		$score += $dash_points;

		if ( $dash_points > 0 ) {
			$signals[] = sprintf( 'High em-dash density (%.1f per 1000 words).', $em_dash_density );
		}

		$triad_points = 0;

		if ( $triad_density >= 8 ) {
			$triad_points = 6;
		} elseif ( $triad_density >= 5 ) {
			$triad_points = 4;
		} elseif ( $triad_density >= 3 ) {
			$triad_points = 2;
		}

		$score += $triad_points;

		if ( $triad_points > 0 ) {
			$signals[] = sprintf( 'Rule-of-three list density (%.1f per 1000 words).', $triad_density );
		}

		if ( count( $tokens ) >= 400 ) {
			$ttr_points = 0;

			if ( $ttr <= 0.35 ) {
				$ttr_points = 5;
			} elseif ( $ttr <= 0.45 ) {
				$ttr_points = 3;
			}

			$score += $ttr_points;

			if ( $ttr_points > 0 ) {
				$signals[] = sprintf( 'Low lexical diversity (type-token ratio %.2f).', $ttr );
			}
		}

		$score   = min( 100, (int) round( $score ) );
		$verdict = 'low';

		if ( $score >= 65 ) {
			$verdict = 'high';
		} elseif ( $score >= 40 ) {
			$verdict = 'likely';
		} elseif ( $score >= 20 ) {
			$verdict = 'possible';
		}

		return array(
			'word_count' => $words,
			'score'      => $score,
			'verdict'    => $verdict,
			'signals'    => $signals,
			'matches'    => $matches,
			'metrics'    => array(
				'weighted_phrase_density_per_1000' => round( $phrase_density, 2 ),
				'phrase_types_matched'             => count( $matches ),
				'sentence_count'                   => $sentence_count,
				'sentence_length_cv'               => round( $cv, 3 ),
				'transition_starter_ratio'         => round( $transition_ratio, 3 ),
				'repeated_starter_ratio'           => round( $repeated_ratio, 3 ),
				'em_dash_per_1000'                 => round( $em_dash_density, 2 ),
				'triad_per_1000'                   => round( $triad_density, 2 ),
				'type_token_ratio'                 => round( $ttr, 3 ),
			),
		);
	}
	private static function normalize( string $text ): string {
		$text = strtr(
			$text,
			array(
				"\xE2\x80\x99" => "'",
				"\xE2\x80\x98" => "'",
				"\xE2\x80\x9C" => '"',
				"\xE2\x80\x9D" => '"',
				"\xC2\xA0"     => ' ',
			)
		);

		return trim( preg_replace( '/[ \t\r\n]+/', ' ', $text ) );
	}

	private static function excerpt( string $text, int $offset ): string {
		$start  = max( 0, $offset - 60 );
		$sample = substr( $text, $start, 180 );
		$sample = preg_replace( '/\s+/u', ' ', $sample );

		return trim( (string) $sample );
	}
}
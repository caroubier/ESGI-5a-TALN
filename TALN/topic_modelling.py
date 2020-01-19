from typing import List

import spacy
from gensim.models import CoherenceModel
from spacy.lang.en import English
from spacy.lemmatizer import Lemmatizer
from spacy.lang.en import LEMMA_INDEX, LEMMA_EXC, LEMMA_RULES
import gensim
from gensim import corpora

PATH="dataset/"
FILE="sample.csv"
FILE2="sample_lyrics.csv"
PATHFILE=PATH+FILE
STOP_WORDS = ["i", "me", "my", "myself", "we", "our", "ours", "ourselves", "you", "your", "yours", "yourself",
              "yourselves",
              "he", "him", "his", "himself", "she", "her", "hers", "herself", "it", "its", "itself", "they", "them",
              "their",
              "theirs", "themselves", "what", "which", "who", "whom", "this", "that", "these", "those", "am", "iam",
              "youre", "is",
              "are",
              "was", "were", "be", "been", "being", "have", "has", "had", "having", "do", "does", "did", "doing",
              "a",
              "an",
              "the", "and", "but", "if", "or", "because", "as", "until", "while", "of", "at", "by", "for", "with",
              "about",
              "against", "between", "into", "through", "during", "before", "after", "above", "below", "to", "from",
              "up",
              "down", "in", "out", "on", "off", "over", "under", "again", "further", "then", "once", "here",
              "there",
              "when",
              "where", "why", "how", "all", "any", "both", "each", "few", "more", "most", "other", "some", "such",
              "no",
              "nor", "not", "only", "own", "same", "so", "than", "too", "very", "s", "t", "can", "will", "just",
              "don",
              "should", "now", "oh", "\'", "?" ",", ":", ";", ",", ".", "!", "im", "oh","ima"]
#spacy_nlp = spacy.load('en_core_web_md')
SPACY_STOPWORDS = spacy.lang.en.stop_words.STOP_WORDS


def set_corpus():
    corpus = []
    return corpus


def extract_words(text) -> List:
    """
    On vire les stopwords
    :param text: lyrics
    :return: tableau des mots des lyrics sans stop_word
    """
    corpus = text.split("\n")
    corpus_words = []
    words = []
    replacelist = set('( ) - \' ? : ; , . !'.split(' '))
    for line in corpus:
        for word in line.lower().split():
            if word not in SPACY_STOPWORDS:
                for char in word:
                    if char in replacelist:
                        word = word.replace(char,"")
                if word not in STOP_WORDS:
                    words.append(word)
        corpus_words.append(words)
        words = []
    #print("corpus words : \n",corpus_words)
    return corpus_words


def lemmatize_corpus(liste, threshold, exclusion=True):
    """
    :param list: corpus_words soir la liste des mots des lyrics
    :return: list de mots lemmatizée des lyrics
    """
    words = []
    corpus_words = liste
    word_frequency = {}
    lemmas_words = []
    for text in corpus_words:
        for token in text:
            if token in word_frequency:
                word_frequency[token] += 1
            else:
                word_frequency[token] = 1
    #print("word frequency : ",word_frequency)
    for text in corpus_words:
        for token in text:
            if exclusion:
                if word_frequency[token] > threshold:
                    words.append(token)
                    lemmatizer = Lemmatizer(LEMMA_INDEX, LEMMA_EXC, LEMMA_RULES)
                    lemmas = lemmatizer(token, u'NOUN')
                    lemmas_words.append(" ".join(lemmas))
            else:
                lemmatizer = Lemmatizer(LEMMA_INDEX, LEMMA_EXC, LEMMA_RULES)
                lemmas = lemmatizer(token, u'NOUN')
                # print("token : ",token," Lemmatization : ",lemmas)
                lemmas_words.append(" ".join(lemmas))
    #print("lemmas words : \n", lemmas_words)
    return lemmas_words


def add_to_corpus(corpus, liste) -> List:
    """
    on ajoute un sac de mots lemmatizés au corpus de texte
    :param corpus: corpus de lyrics
    :param text: chanson après lemmatization cleaning etc.
    :return:
    """
    return corpus.append(liste)


def lda_on_corpus(corpus):
    """
    lda sur le corpus de texte
    :param corpus: liste contenant les listes de mots des lyrics
    :return: gensim.models.ldamodel.LdaModel
    """
    id2word = corpora.Dictionary(corpus) # vectorisation de chaque mot du corpus
    texts = corpus
    corpus = [id2word.doc2bow(text) for text in texts] #mapping de (word_id,word_frequency)
    lda_model = gensim.models.ldamodel.LdaModel(corpus=corpus,
                                                id2word=id2word,
                                                num_topics=1,
                                                random_state=100,
                                                update_every=1,
                                                chunksize=100,
                                                passes=5,
                                                alpha='auto',
                                                per_word_topics=True)
    #print(lda_model.print_topics())
    return lda_model


def extract_lda_values(lda_model):
    """
    retourne les values sorties par le modèle
    :param lda_model:
    :return: dictionnaire des valeurs retournées par le modèle
    """
    keyword_list = lda_model.print_topics()
    dic_id = {}
    dic_values = {}
    for val in keyword_list:
        key = val[0]
        value = ""
        donnee = val[1].replace("'", '')
        donnee = donnee.replace('"', "")
        tab = donnee.strip().split("+")
        for val in tab:
            val = val.strip().split("*")
            dic_values[val[1]] = val[0]
        #print(value)
        dic_id[key] = dic_values
    #print(dic_id)
    return dic_id


def run():
    corpus = set_corpus()
    corpus_words = extract_words(PATH+FILE)
    lemmas_words = lemmatize_corpus(corpus_words,1,exclusion=False)
    add_to_corpus(corpus,lemmas_words)
    lda_model = lda_on_corpus(corpus)
    extract_lda_values(lda_model)

if __name__ == "__main__":
    run()

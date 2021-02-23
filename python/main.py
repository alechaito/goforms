import graphviz
from matplotlib import pyplot as plt
import numpy as np
import pandas as pd 
import seaborn as sns
import pydotplus

from io import BytesIO as StringIO
from scipy import misc

from sklearn import tree # pack age tree 
from sklearn.metrics import accuracy_score # medir % acerto
from sklearn.model_selection import train_test_split # cortar dataset
from sklearn.tree import DecisionTreeClassifier, export_graphviz # arvore de decixao classificacao e graphviz para visualizar


UNSUPPORTED_TYPES = [0]
NEW_DATA = {}

df = pd.read_csv('evaluates.csv', header=None)
df.columns = ['id', 'qest_id', 'qest_name','response', 'qest_type', 'id_patient','quiz_id']
df = df.drop(['id', 'quiz_id', 'qest_id'], axis=1)

for value in UNSUPPORTED_TYPES:
    df = df.drop(df[df.qest_type == value].index)

df = df.drop(['qest_type'], axis=1)

print(df.head(5))

unique_qest_names =  pd.unique(df[["qest_name"]].values.ravel())
unique_patient_ids =  pd.unique(df[["id_patient"]].values.ravel())

def create_new_data_columns():
    global unique_qest_names
    global NEW_DATA
    for value in unique_qest_names:
        NEW_DATA[value] = []

create_new_data_columns()

for idx in unique_patient_ids:
    data = df.loc[df['id_patient'] == idx]
    #print(data)
    for index, row in data.iterrows():
        NEW_DATA[row['qest_name']].append(row['response'])


data_transformed = pd.DataFrame(NEW_DATA)
print(data_transformed.columns.values)

test_size = int(round(len(data_transformed)*0.3))

train, test = train_test_split(data_transformed, test_size=test_size)


print('Tamanho do set de treino: {},\nTamanho teste: {}'.format(len(train), len(test) ))


tree = DecisionTreeClassifier(min_samples_split=100)

features = []

for qest in unique_qest_names:
    features.append(str(qest))

target = 'Tenho estado ansiosa ou preocupada sem motivo'
features.remove(target)

x_train = train[features]
y_train = train[target]

x_test = test[features]
y_test = test[target]

dct = tree.fit(x_train, y_train) # scikit fez uma decision tree

# visualizando

def showTree(tree, features, path):
    file = StringIO()
    export_graphviz(tree, out_file=file, feature_names=features)
    pydotplus.graph_from_dot_data(file.getvalue()).write_png(path)
    img = misc.imread(path)
    plt.rcParams["figure.figsize"] = (20, 20)
    plt.imshow(img)


showTree(dct, features, 'minhaprimeiradct.png')


y_pred = tree.predict(x_test)

score = accuracy_score(y_test, y_pred)*100

print('Score = {}'.format(score))